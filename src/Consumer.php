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

    public function consume($queue = '', $consumer_tag = '', $no_local = false, $no_ack = false, $exclusive = false, $nowait = false, $callback = null, $ticket = null, $arguments = [])
    {
        echo "Consuming from queue: $queue\n";

        try {
            $connection = AMQPConnectionFactory::create($this->config);
            $channel = $connection->channel();

            echo " [*] Waiting for messages. To exit press CTRL+C\n";

            if (!$callback) {
                $callback = function ($msg) {
                    echo ' [x] Received Message: ', $msg->body, "\n";
                };
            }

            $channel->basic_consume($queue, $consumer_tag, $no_local, $no_ack, $exclusive, $nowait, $callback, $ticket, $arguments);

            $channel->consume();
        } catch (\Throwable $exception) {
            echo "Error: " . $exception->getMessage() . "\n";
        }
    }
}
