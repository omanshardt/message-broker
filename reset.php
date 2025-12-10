<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\MyAdmin;

$admin = new MyAdmin();
$admin->reset();
echo "Exchanges and Queues resetted.";