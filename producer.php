<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

$config = require __DIR__ . '/config.php';

use App\Utils;

$handle = fopen("php://stdin", "r");
$exchange = Utils::create_or_select_exchange($handle);

echo "Enter message payload [Hello World!]: ";
$payload = trim(fgets($handle));
if (empty($payload)) {
    $payload = 'Hello World!';
}

try {
    $connection = AMQPConnectionFactory::create($config);
    $channel = $connection->channel();

    $msg = new AMQPMessage($payload);
    $channel->basic_publish($msg, $exchange);

    echo " [x] Sent '$payload' to exchange '$exchange'\n";
    sleep(10);

    $channel->close();
    $connection->close();
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
