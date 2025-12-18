<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Administrator;

$config = require __DIR__ . '/../config.php';
$admin = new Administrator($config);

$handle = fopen("php://stdin", "r");

// Get Username
echo "Enter username: ";
$username = trim(fgets($handle));
if (empty($username)) {
    die("Username cannot be empty.\n");
}

// Get Password (hidden)
echo "Enter password: ";
// Disable echo
shell_exec('stty -echo');
$password = trim(fgets($handle));
// Enable echo
shell_exec('stty echo');
echo "\n"; // Newline after password input since echo was disabled

if (empty($password)) {
    die("Password cannot be empty.\n");
}

// Get Role/Tags
echo "Select role:\n";
echo "1) Producer/Consumer (default, no tags)\n";
echo "2) Administrator (tag: administrator)\n";
echo "3) Monitoring (tag: monitoring)\n";
echo "Enter selection [1]: ";
$selection = trim(fgets($handle));

$tags = '';
switch ($selection) {
    case '2':
        $tags = 'administrator';
        break;
    case '3':
        $tags = 'monitoring';
        break;
    default:
        $tags = ''; // Management plugin uses 'management' tag for basic access, but prompt said "Producer/Consumer" which usually don't need management UI access. 
        // However, if they need UI access, it should be 'management'. 
        // The prompt asked for "Producer and the customer" configuration. 
        // Usually app users don't need tags unless they access the UI.
        // I will stick to empty string as "default" unless user specified otherwise.
        break;
}

echo "Creating user '$username' with tags '$tags'...\n";
$result = $admin->createUser($username, $password, $tags);

if ($result !== false) {
    echo "User created successfully.\n";
    // $admin->setPermissions($username);
    // echo "Permissions granted for vhost '/'.\n";
}
