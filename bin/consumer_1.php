<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;

$config = require __DIR__ . '/../config.php';
$config->setUser('consumer-1');
$config->setPassword(App\Utils::getPassword($app, 'consumer-1'));

use App\Utils;

$handle = fopen("php://stdin", "r");
$queue = Utils::create_or_select_queue($handle);

use App\Consumer;

$consumer = new Consumer($config);
$consumer->consume($queue, "my_consumer_1_tag", false, false, false, false, null);
fclose($handle);