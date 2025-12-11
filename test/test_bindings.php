<?php

require_once __DIR__ . '/../inc/display_errors.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Administrator;

$config = require __DIR__ . '/../config.php';
$admin = new Administrator($config);

echo "Resetting...\n";
$admin->reset();

echo "\nCreating resources...\n";
$admin->createExchangeViaAPI('ex:api', 'fanout');

$admin->createQueueViaAPI('q:api_1');
$admin->createQueueViaAPI('q:api_2');

echo "\nCreating binding via API (q:api_1 -> ex:api)...\n";
$admin->createBindingViaAPI('q:api_1', 'ex:api');

echo "\nCreating binding via Framework (q:api_2 -> ex:api)...\n";
$admin->connect();
$admin->createBindingViaFramework('q:api_2', 'ex:api');
$admin->disconnect();

echo "\nVerifying bindings:\n";
$bindings = json_decode($admin->getBindings(), true);
foreach ($bindings as $b) {
    if ($b['source'] === 'ex:api') {
        echo "- Found binding: {$b['source']} -> {$b['destination']} ({$b['destination_type']})\n";
    }
}

sleep(15);

echo "\nDeleting bindings...\n";
$admin->deleteBindings();

echo "\nVerifying deletion:\n";
$bindings = json_decode($admin->getBindings(), true);
$found = false;
foreach ($bindings as $b) {
    if ($b['source'] === 'ex:api') {
        echo "- Found binding: {$b['source']} -> {$b['destination']}\n";
        $found = true;
    }
}
if (!$found) {
    echo "- No bindings found for ex:api\n";
}

sleep(15);


echo "\nResetting...\n";
$admin->reset();
