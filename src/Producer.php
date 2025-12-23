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

    public function publish($exchange, $messageBody, $routing_key = '', $mandatory = false, $immediate = false, $ticket = null)
    {
        try {
            $connection = AMQPConnectionFactory::create($this->config);
            $channel = $connection->channel();

            $msg = new AMQPMessage($messageBody);
            $channel->basic_publish($msg, $exchange, $routing_key, $mandatory, $immediate, $ticket);

            echo " [x] Sent Message: '$messageBody' to Exchange: '$exchange' with Routing Key: '$routing_key'\n";

            $channel->close();
            $connection->close();
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
