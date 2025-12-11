<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Administrator;

$config = require __DIR__ . '/config.php';
$admin = new Administrator($config);

echo "Initial Users:\n";
$users = json_decode($admin->getUsers(), true);
foreach ($users as $u) {
    echo "- {$u['name']}\n";
}

echo "\nCreating user 'test_user'...\n";
$admin->createUser('test_user', 'password123', 'monitoring');

echo "\nUsers after creation:\n";
$users = json_decode($admin->getUsers(), true);
foreach ($users as $u) {
    echo "- {$u['name']}\n";
}

echo "\nDeleting users (should exclude admin)...\n";
$admin->deleteUsers();

echo "\nUsers after deletion:\n";
$users = json_decode($admin->getUsers(), true);
foreach ($users as $u) {
    echo "- {$u['name']}\n";
}

// Cleanup just in case
if (count($users) > 1) {
    echo "\nCleanup failed? Manual check required.\n";
} else {
    echo "\nVerification successful.\n";
}
