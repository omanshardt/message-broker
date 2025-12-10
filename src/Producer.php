<?php

namespace App;

use PhpAmqpLib\Connection\AMQPConnectionFactory;
use PhpAmqpLib\Message\AMQPMessage;

class Producer
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function publish($exchange, $messageBody)
    {
        try {
            $connection = AMQPConnectionFactory::create($this->config);
            $channel = $connection->channel();

            $msg = new AMQPMessage($messageBody);
            $channel->basic_publish($msg, $exchange);

            echo " [x] Sent '$messageBody' to exchange '$exchange'\n";

            $channel->close();
            $connection->close();
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
