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

use App\Producer;

$producer = new Producer($config);
$producer->publish($exchange, $payload);
