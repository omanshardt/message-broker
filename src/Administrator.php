<?php

namespace App;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPConnectionFactory;

class Administrator
{
    private $config;
    private AbstractConnection $connection;
    private AMQPChannel $channel;

    public function __construct($config = null)
    {
        $this->config = $config;
    }

    public function connect()
    {
        if ($this->config === null) {
            throw new \Exception("Config is required for framework connection.");
        }
        $this->connection = AMQPConnectionFactory::create($this->config);
        $this->channel = $this->connection->channel();
    }

    public function disconnect()
    {
        $this->channel->close();
        $this->connection->close();
    }

    private function callApi($method, $path, $body = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://135.181.206.8:15672/api/' . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = [
            'Authorization: Basic YWRtaW46ZnVlcmNodGVnb3R0',
        ];

        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $headers[] = 'Content-Type: application/json';
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (!$response && curl_errno($ch)) {
            die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }

        curl_close($ch);

        return $response;
    }


    public function createExchangeViaAPI($name, $type = 'direct', $durable = true, $auto_delete = false, $internal = false, $arguments = [])
    {
        $body = [
            'type' => $type,
            'durable' => $durable,
            'auto_delete' => $auto_delete,
            'internal' => $internal,
            'arguments' => $arguments
        ];
        return $this->callApi('PUT', 'exchanges/%2F/' . urlencode($name), json_encode($body));
    }

    public function createExchangeViaFramework($exchange = 'ex:mydefault', $type = 'fanout', $passive = false, $durable = false, $auto_delete = true, $internal = false, $nowait = false, $arguments = array(), $ticket = null)
    {
        $this->channel->exchange_declare($exchange, $type, $passive, $durable, $auto_delete, $internal, $nowait, $arguments, $ticket);
    }

    public function getExchanges()
    {
        return $this->callApi('GET', 'exchanges/');
    }

    public function deleteExchanges()
    {
        $exchanges = json_decode($this->getExchanges(), true);
        foreach ($exchanges as $exchange) {
            $name = $exchange['name'];
            // Skip default exchange (empty name) and internal amqp.* / amq.* exchanges
            if (empty($name) || strpos($name, 'amqp.') === 0 || strpos($name, 'amq.') === 0) {
                continue;
            }
            echo "Deleting exchange: $name\n";
            $this->callApi('DELETE', 'exchanges/%2F/' . urlencode($name));
        }
    }


    public function createQueueViaAPI($name, $durable = true, $auto_delete = false, $arguments = [])
    {
        $body = [
            'durable' => $durable,
            'auto_delete' => $auto_delete,
            'arguments' => $arguments
        ];
        return $this->callApi('PUT', 'queues/%2F/' . urlencode($name), json_encode($body));
    }

    public function createQueueViaFramework($queue = 'q:mydefault', $passive = false, $durable = false, $exclusive = false, $auto_delete = true, $nowait = false, $arguments = array(), $ticket = null)
    {
        $this->channel->queue_declare($queue, $passive, $durable, $exclusive, $auto_delete, $nowait, $arguments, $ticket);
    }

    public function getQueues()
    {
        return $this->callApi('GET', 'queues/%2F');
    }

    public function deleteQueues()
    {
        $queues = json_decode($this->getQueues(), true);
        foreach ($queues as $queue) {
            $name = $queue['name'];
            echo "Deleting queue: $name\n";
            $this->callApi('DELETE', 'queues/%2F/' . urlencode($name));
        }
    }


    public function getBindings()
    {
        return $this->callApi('GET', 'bindings/');
    }

    public function createBindingViaAPI($queue, $exchange, $routing_key = '', $arguments = [])
    {
        $body = [
            'routing_key' => $routing_key,
            'arguments' => $arguments
        ];
        // This is the original api call as proposed from Antigravity
        // return $this->callApi('POST', "bindings/%2F/e/" . urlencode($source) . "/q/" . urlencode($destination), json_encode($body));
        // The sgnature of this method accordingly was:
        // public function createBindingViaAPI($source, $destination, $routing_key = '', $arguments = [])
        // with $source being the exchange and $destination being the queue.
        // I switched to more recognizable names and switched arguments ($exchange, $queue) to match the signature of the framework method. 
        return $this->callApi('POST', "bindings/%2F/e/" . urlencode($exchange) . "/q/" . urlencode($queue), json_encode($body));
    }

    public function createBindingViaFramework($queue, $exchange, $routing_key = '', $nowait = false, $arguments = [], $ticket = null)
    {
        $this->channel->queue_bind($queue, $exchange, $routing_key, $nowait, $arguments, $ticket);
    }

    public function deleteBindings()
    {
        $bindings = json_decode($this->getBindings(), true);
        foreach ($bindings as $binding) {
            $source = $binding['source'];
            $destination = $binding['destination'];
            $type = $binding['destination_type'] === 'queue' ? 'q' : 'e';
            $props = $binding['properties_key'];

            if (empty($source)) {
                continue; // Skip default exchange bindings
            }

            echo "Deleting binding: $source -> $destination\n";
            $this->callApi('DELETE', "bindings/%2F/e/" . urlencode($source) . "/$type/" . urlencode($destination) . "/" . urlencode($props));
        }
    }


    public function getUsers()
    {
        return $this->callApi('GET', 'users/');
    }

    public function createUser($name, $password, $tags = '')
    {
        $users = json_decode($this->getUsers(), true);
        foreach ($users as $user) {
            if ($user['name'] === $name) {
                echo "User '$name' already exists.\n";
                return false;
            }
        }

        $body = [
            'password' => $password,
            'tags' => $tags
        ];
        $ret = $this->callApi('PUT', 'users/' . urlencode($name), json_encode($body));

        if ($ret !== false) {
            $this->setPermissions($name);
            return true;
        }
        return false;
    }

    public function setPermissions($user, $vhost = '/', $configure = '.*', $write = '.*', $read = '.*')
    {
        $body = [
            'configure' => $configure,
            'write' => $write,
            'read' => $read
        ];
        return $this->callApi('PUT', 'permissions/' . urlencode($vhost) . '/' . urlencode($user), json_encode($body));
    }

    public function deleteUsers()
    {
        $users = json_decode($this->getUsers(), true);
        foreach ($users as $user) {
            $name = $user['name'];
            if ($name === 'admin') {
                continue;
            }
            echo "Deleting user: $name\n";
            $this->callApi('DELETE', 'users/' . urlencode($name));
        }
    }

    public function reset()
    {
        $this->deleteBindings();
        $this->deleteQueues();
        $this->deleteExchanges();
    }
}
