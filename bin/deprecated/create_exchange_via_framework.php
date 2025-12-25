<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

$config = require __DIR__ . '/../../config.php';

use App\Utils;
use App\Administrator;

echo "Create an exchange.\n";

$handle = fopen("php://stdin", "r");
$exchange = Utils::create_or_select_exchange($handle);

$admin = new Administrator($config);
$admin->connect();
$admin->createExchangeViaFramework($exchange, 'fanout', false, false, false);
$admin->disconnect();
echo " [x] Created exchange '$exchange' via FRAMEWORK (if not already existed)\n";
