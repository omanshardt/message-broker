<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Administrator;

$admin = new Administrator();
$admin->deleteUsers();
echo "Users deleted.";