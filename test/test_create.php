<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Administrator;

$admin = new Administrator();

// Reset first
echo "Resetting...\n";
$admin->reset();

echo "Creating Exchange 'test_exchange'...\n";
$admin->createExchange('test_exchange', 'fanout');

echo "Creating Queue 'test_queue'...\n";
$admin->createQueue('test_queue');

echo "\nExchanges:\n";
$exchanges = json_decode($admin->getExchanges(), true);
foreach ($exchanges as $ex) {
    if ($ex['name'] === 'test_exchange') {
        echo "- Found test_exchange\n";
    }
}

echo "\nQueues:\n";
$queues = json_decode($admin->getQueues(), true);
foreach ($queues as $q) {
    if ($q['name'] === 'test_queue') {
        echo "- Found test_queue\n";
    }
}

// Cleanup
echo "\nCleaning up...\n";
$admin->reset();
