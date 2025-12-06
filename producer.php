<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

$config = require __DIR__ . '/config.php';

try {
    $connection = AMQPConnectionFactory::create($config);
    $channel = $connection->channel();

    $channel->queue_declare('basic_queue', false, false, false, false);

    $payload = 'Murmeltier Hello World!';
    $msg = new AMQPMessage($payload);
    $channel->basic_publish($msg, '', 'basic_queue');

    echo " [x] Sent '$payload'\n";

    $channel->close();
    $connection->close();
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
