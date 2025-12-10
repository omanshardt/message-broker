<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;

$config = require __DIR__ . '/config.php';
$config->setUser('consumer-2');
$config->setPassword('consumer-2');

use App\Utils;

$handle = fopen("php://stdin", "r");
$queue = Utils::create_or_select_queue($handle);

use App\Consumer;

$consumer = new Consumer($config);
$consumer->consume($queue);
