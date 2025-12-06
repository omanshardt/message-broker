<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

$config = require __DIR__ . '/config.php';

require_once __DIR__ . '/utils.php';

$handle = fopen("php://stdin", "r");
$queue = select_queue($handle);

echo "Enter message payload [Hello World!]: ";
$payload = trim(fgets($handle));
if (empty($payload)) {
    $payload = 'Hello World!';
}

try {
    $connection = AMQPConnectionFactory::create($config);
    $channel = $connection->channel();

    $channel->queue_declare($queue, false, false, false, false);

    $msg = new AMQPMessage($payload);
    $channel->basic_publish($msg, '', $queue);

    echo " [x] Sent '$payload' to '$queue'\n";

    $channel->close();
    $connection->close();
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
