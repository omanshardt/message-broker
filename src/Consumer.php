<?php

namespace App;

use PhpAmqpLib\Connection\AMQPConnectionFactory;

class Consumer
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function consume($queue)
    {
        echo "Consuming from queue: $queue\n";

        try {
            $connection = AMQPConnectionFactory::create($this->config);
            $channel = $connection->channel();

            echo " [*] Waiting for messages. To exit press CTRL+C\n";

            $callback = function ($msg) {
                echo ' [x] Received ', $msg->body, "\n";
            };

            $channel->basic_consume($queue, '', false, true, false, false, $callback);

            $channel->consume();
        } catch (\Throwable $exception) {
            echo "Error: " . $exception->getMessage() . "\n";
        }
    }
}
