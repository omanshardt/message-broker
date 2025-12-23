<?php

require_once __DIR__ . '/../inc/display_errors.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;
use App\Administrator;

use App\Utils;

echo "Setup one exchange and three queues and bind them to each other.\n";

$exchange = $app['exchanges']['fanout'];
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