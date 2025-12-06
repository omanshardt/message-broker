<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$config = require __DIR__ . '/config.php';

try {
    $connection = new AMQPStreamConnection(
        $config['host'],
        $config['port'],
        $config['user'],
        $config['pass']
    );
    $channel = $connection->channel();

    $channel->queue_declare('hello', false, false, false, false);

    echo " [*] Waiting for messages. To exit press CTRL+C\n";

    $callback = function ($msg) {
        echo ' [x] Received ', $msg->body, "\n";
    };

    $channel->basic_consume('hello', '', false, true, false, false, $callback);

    $channel->consume();
} catch (\Throwable $exception) {
    echo "Error: " . $exception->getMessage() . "\n";
}
