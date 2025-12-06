<?php

use PhpAmqpLib\Connection\AMQPConnectionConfig;

$config = new AMQPConnectionConfig();
$config->setHost('135.181.206.8');
$config->setPort(5672);
$config->setUser('admin');
$config->setPassword('fuerchtegott');

return $config;
