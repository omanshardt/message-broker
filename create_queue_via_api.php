<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

$config = require __DIR__ . '/config.php';

use App\Utils;
use App\Administrator;

echo "Create a queue.\n";

$handle = fopen("php://stdin", "r");
$queue = Utils::create_or_select_queue($handle);

$admin = new Administrator($config);
$admin->createQueueViaAPI($queue);
echo " [x] Created queue '$queue' via API (if not already existed)\n";
