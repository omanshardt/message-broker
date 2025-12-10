<?php

namespace App;

use PhpAmqpLib\Channel\AMQPChannel;

class MyAdmin
{
    private function callApi($method, $path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://135.181.206.8:15672/api/' . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic YWRtaW46ZnVlcmNodGVnb3R0',
        ]);

        $response = curl_exec($ch);

        if (!$response && curl_errno($ch)) {
            die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }

        curl_close($ch);

        return $response;
    }

    public function getExchanges()
    {
        return $this->callApi('GET', 'exchanges/');
    }

    public function getQueues()
    {
        return $this->callApi('GET', 'queues/%2F');
    }

    public function getBindings()
    {
        return $this->callApi('GET', 'bindings/');
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

    public function deleteQueues()
    {
        $queues = json_decode($this->getQueues(), true);
        foreach ($queues as $queue) {
            $name = $queue['name'];
            echo "Deleting queue: $name\n";
            $this->callApi('DELETE', 'queues/%2F/' . urlencode($name));
        }
    }

    public function reset()
    {
        $this->deleteQueues();
        $this->deleteExchanges();
    }
}
