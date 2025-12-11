<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

$config = require __DIR__ . '/../config.php';

use App\Utils;
use App\Administrator;

echo "Create an exchange.\n";

$handle = fopen("php://stdin", "r");
$exchange = Utils::create_or_select_exchange($handle);

$admin = new Administrator($config);
$admin->createExchangeViaAPI($exchange);
echo " [x] Created exchange '$exchange' via API (if not already existed)\n";
