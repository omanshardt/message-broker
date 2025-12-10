<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\MyAdmin;

$admin = new MyAdmin();

echo "Current Exchanges:\n";
echo $admin->getExchanges() . "\n\n";

echo "Current Queues:\n";
echo $admin->getQueues() . "\n\n";

echo "Deleting Exchanges...\n";
$admin->deleteExchanges();

echo "Deleting Queues...\n";
$admin->deleteQueues();

echo "\nExchanges after deletion:\n";
echo $admin->getExchanges() . "\n\n";

echo "Queues after deletion:\n";
echo $admin->getQueues() . "\n\n";
