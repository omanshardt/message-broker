<?php

require_once __DIR__ . '/../inc/display_errors.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;
use App\Administrator;

use App\Utils;

$type = isset($argv[1]) ? $argv[1] : 'fanout';

if (!array_key_exists($type, $app['exchanges'])) {
    die("Error: Invalid environment type '$type'. Available types: " . implode(', ', array_keys($app['exchanges'])) . "\n");
}

echo "Setting up environment for type: $type\n";

$exchange = $app['exchanges'][$type];
$queues = $exchange['queues'];
$admin = new Administrator($config, $app);
$admin->connect();
$admin->createExchangeViaFramework($exchange['name'], $exchange['type'], $exchange['durable'], $exchange['auto_delete'], $exchange['internal'], $exchange['nowait'], $exchange['arguments'], $exchange['ticket']);
foreach ($queues as $queue) {
    $admin->createQueueViaFramework($queue['name'], $queue['passive'], $queue['durable'], $queue['exclusive'], $queue['auto_delete'], $queue['nowait'], $queue['arguments'], $queue['ticket']);
    foreach ($queue['bindings'] as $binding) {
        $admin->createBindingViaFramework($queue['name'], $exchange['name'], $binding['routing_key'], false, $binding['arguments'], null);
    }
}