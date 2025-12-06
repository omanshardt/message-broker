<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

$config = require __DIR__ . '/config.php';

require_once __DIR__ . '/utils.php';

$handle = fopen("php://stdin", "r");
$exchange = create_or_select_exchange($handle);
$queue = create_or_select_queue($handle);

echo "Enter message payload [Hello World!]: ";
$payload = trim(fgets($handle));
if (empty($payload)) {
    $payload = 'Hello World!';
}

try {
    $connection = AMQPConnectionFactory::create($config);
    $channel = $connection->channel();

    $channel->exchange_declare($exchange, 'fanout', false, false, false);
    $channel->queue_declare($queue, false, false, false, false);
    $channel->queue_bind($queue, $exchange);

    $msg = new AMQPMessage($payload);
    $channel->basic_publish($msg, $exchange);

    echo " [x] Sent '$payload' to exchange '$exchange'\n";

    $channel->close();
    $connection->close();
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
