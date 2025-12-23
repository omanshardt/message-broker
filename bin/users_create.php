<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Administrator;

$config = require __DIR__ . '/../config.php';
$admin = new Administrator($config);

foreach ($app['users'] as $user) {
    $result = $admin->createUser($user['name'], $user['password'], $user['role']);
    if ($result) {
        echo "User '{$user['name']}' created successfully.\n";
    } else {
        echo "Failed to create user '{$user['name']}'.\n";
    }
}

echo "Done\n";