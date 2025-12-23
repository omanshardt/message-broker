<?php
require_once __DIR__ . '/../inc/display_errors.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

use App\Administrator;

$admin = new Administrator($config, $app);
$admin->deleteUsers();
echo "Users deleted.";