<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

$config = require __DIR__ . '/../config.php';

use App\Utils;

echo "Setup one exchange and one queue and bind them to each other.\n";

$handle = fopen("php://stdin", "r");
$exchange = 'ex:direct';

try {
    $connection = AMQPConnectionFactory::create($config);
    $channel = $connection->channel();

    $channel->exchange_declare($exchange, 'direct', false, false, false);

    $channel->queue_declare('qd:info', false, false, false, false);
    $channel->queue_declare('qd:warning', false, false, false, false);
    $channel->queue_declare('qd:error', false, false, false, false);

    $channel->queue_bind('qd:info', $exchange, 'info');
    $channel->queue_bind('qd:warning', $exchange, 'warning');
    $channel->queue_bind('qd:error', $exchange, 'error');

    echo " [x] Created exchange '$exchange' (if not already existed)\n";
    echo " [x] Created queue 'qd:info' (if not already existed)\n";
    echo " [x] Created queue 'qd:warning' (if not already existed)\n";
    echo " [x] Created queue 'qd:error' (if not already existed)\n";
    echo " [x] Bound queue 'qd:info' to exchange '$exchange' (if not already bound)\n";
    echo " [x] Bound queue 'qd:warning' to exchange '$exchange' (if not already bound)\n";
    echo " [x] Bound queue 'qd:error' to exchange '$exchange' (if not already bound)\n";

    $channel->close();
    $connection->close();
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
