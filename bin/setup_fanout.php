<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

$config = require __DIR__ . '/../config.php';

use App\Utils;

echo "Setup one exchange and one queue and bind them to each other.\n";

$handle = fopen("php://stdin", "r");
$exchange = Utils::create_or_select_exchange($handle);
$queue = Utils::create_or_select_queue($handle);

try {
    $connection = AMQPConnectionFactory::create($config);
    $channel = $connection->channel();

    $channel->exchange_declare('ex:fanout', 'fanout', false, false, false);
    $channel->queue_declare($queue, false, false, false, false);
    $channel->queue_bind($queue, $exchange);

    echo " [x] Created exchange '$exchange' (if not already existed)\n";
    echo " [x] Created exchange '$queue' (if not already existed)\n";
    echo " [x] Bound queue '$queue' to exchange '$exchange' (if not already bound)\n";

    $channel->close();
    $connection->close();
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
