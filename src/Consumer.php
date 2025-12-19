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

            if (!$callback) {
                $callback = function ($msg) use ($channel, $no_ack) {
                    // file_put_contents('messages.php', print_r($msg, true) . "\n");
                    echo " [x] DelveryTag: " . $msg->delivery_info['delivery_tag'] . "\n";
                    echo " [x] Received Message: " . $msg->body . "\n";
                    $handle = fopen("php://stdin", "r");
                    if (!$no_ack) {
                        echo "[x] Do you want to acknowledge the message? (y/n)\n";
                        $response = trim(fgets($handle));
                        if ($response === 'y') {
                            $channel->basic_ack($msg->delivery_info['delivery_tag']);
                            echo "[x] Message acknowledged\n";
                        } else {
                            echo "[x] Message NOT acknowledged\n";
                        }
                    }
                    fclose($handle);
                };
            }

            $consumer_tag = $channel->basic_consume($queue, $consumer_tag, $no_local, $no_ack, $exclusive, $nowait, $callback, $ticket, $arguments);
            echo " [*] Consumer with Consumer Tag running: $consumer_tag\n";
            echo " [*] Acknowledgement: " . (($no_ack) ? "Automatische Bestätigung der Verarbeitung. Nachricht werden gelöscht.\n" : "Keine automatische Bestätigung der Verarbeitung. Nachrichten werden NICHT gelöscht.\n");
            echo " [*] Waiting for messages. To exit press CTRL+C\n";
            $channel->consume();
        } catch (\Throwable $exception) {
            echo "Error: " . $exception->getMessage() . "\n";
        }
    }
}
