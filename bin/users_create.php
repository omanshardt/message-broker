<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Administrator;

$config = require __DIR__ . '/../config.php';
$admin = new Administrator($config);

function createUser($username, $password, $tags)
{
    global $admin;
    echo "Creating user '$username' with tags '$tags'...\n";
    $result = $admin->createUser($username, $password, $tags);
}

createUser('consumer-1', 'Test!234', 'administrator');
createUser('consumer-2', 'Test!234', 'administrator');
createUser('consumer-3', 'Test!234', 'administrator');
createUser('producer-1', 'Test!234', 'administrator');
createUser('producer-2', 'Test!234', 'administrator');
createUser('producer-3', 'Test!234', 'administrator');

echo "Done\n";