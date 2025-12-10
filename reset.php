<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\MyAdmin;

$admin = new MyAdmin();
// echo $admin->getExchanges();
// echo $admin->getQueues();
// echo $admin->getBindings();
$admin->reset();
echo "Exchanges and Queues resetted.";