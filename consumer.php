<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;

$config = require __DIR__ . '/config.php';

require_once __DIR__ . '/utils.php';

$handle = fopen("php://stdin", "r");
$exchange = create_or_select_exchange($handle);
$queue = create_or_select_queue($handle);

echo "Consuming from queue: $queue (bound to exchange: $exchange)\n";

try {
    $connection = AMQPConnectionFactory::create($config);
    $channel = $connection->channel();

    $channel->exchange_declare($exchange, 'fanout', false, false, false);
    $channel->queue_declare($queue, false, false, false, false);
    $channel->queue_bind($queue, $exchange);

    echo " [*] Waiting for messages. To exit press CTRL+C\n";

    $callback = function ($msg) {
        echo ' [x] Received ', $msg->body, "\n";
    };

    $channel->basic_consume($queue, '', false, true, false, false, $callback);

    $channel->consume();
} catch (\Throwable $exception) {
    echo "Error: " . $exception->getMessage() . "\n";
}
