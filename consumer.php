<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;

$config = require __DIR__ . '/config.php';
$config->setUser('consumer-2');
$config->setPassword('consumer-2');

use App\Utils;

$handle = fopen("php://stdin", "r");
$queue = Utils::create_or_select_queue($handle);

echo "Consuming from queue: $queue\n";

try {
    $connection = AMQPConnectionFactory::create($config);
    $channel = $connection->channel();

    echo " [*] Waiting for messages. To exit press CTRL+C\n";

    $callback = function ($msg) {
        echo ' [x] Received ', $msg->body, "\n";
    };

    $channel->basic_consume($queue, '', false, true, false, false, $callback);

    $channel->consume();
} catch (\Throwable $exception) {
    echo "Error: " . $exception->getMessage() . "\n";
}
