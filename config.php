<?php

use PhpAmqpLib\Connection\AMQPConnectionConfig;

$config = new AMQPConnectionConfig();
$config->setHost('135.181.206.8');
$config->setPort(5672);
$config->setUser('admin');
$config->setPassword('fuerchtegott');

$app = [
    'users' => [
        [
            'name' => 'consumer-1',
            'password' => 'Test!234',
            'role' => 'administrator',
        ],
        [
            'name' => 'consumer-2',
            'password' => 'Test!234',
            'role' => 'administrator',
        ],
        [
            'name' => 'consumer-3',
            'password' => 'Test!234',
            'role' => 'administrator',
        ],
        [
            'name' => 'producer-1',
            'password' => 'Test!234',
            'role' => 'administrator',
        ],
        [
            'name' => 'producer-2',
            'password' => 'Test!234',
            'role' => 'administrator',
        ],
        [
            'name' => 'producer-3',
            'password' => 'Test!234',
            'role' => 'administrator',
        ]
    ],
    'exchanges' => [
        'fanout' => [
            'name' => 'ex:fanout',
            'type' => 'fanout',
            'passive' => false,
            'durable' => false,
            'auto_delete' => true,
            'internal' => false,
            'nowait' => false,
            'arguments' => [],
            'ticket' => null,
            'queues' => [
                [
                    'name' => 'qd:fanout-1',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                    'bindings' => [
                        [
                            'routing_key' => '',
                            'arguments' => [],
                        ],
                    ],
                ],
                [
                    'name' => 'qd:fanout-2',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                    'bindings' => [
                        [
                            'routing_key' => '',
                            'arguments' => [],
                        ],
                    ],
                ],
                [
                    'name' => 'qd:fanout-3',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                    'bindings' => [
                        [
                            'routing_key' => '',
                            'arguments' => [],
                        ],
                    ],
                ],
            ],
        ],
        'direct' => [
            'name' => 'ex:direct',
            'type' => 'direct',
            'passive' => false,
            'durable' => false,
            'auto_delete' => true,
            'internal' => false,
            'nowait' => false,
            'arguments' => [],
            'ticket' => null,
            'queues' => [
                [
                    'name' => 'qd:direct-info',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                    'bindings' => [
                        [
                            'routing_key' => 'info',
                            'arguments' => [],
                        ],
                    ],
                ],
                [
                    'name' => 'qd:direct-warning',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                    'bindings' => [
                        [
                            'routing_key' => 'warning',
                            'arguments' => [],
                        ],
                    ],
                ],
                [
                    'name' => 'qd:direct-error',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                    'bindings' => [
                        [
                            'routing_key' => 'error',
                            'arguments' => [],
                        ],
                    ],
                ],
            ],
        ],
        'topic' => [
            'name' => 'ex:topic',
            'type' => 'topic',
            'passive' => false,
            'durable' => false,
            'auto_delete' => true,
            'internal' => false,
            'nowait' => false,
            'arguments' => [],
            'ticket' => null,
            'queues' => [
                [
                    'name' => 'qd:topic-1',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                ],
                [
                    'name' => 'qd:topic-2',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                ],
                [
                    'name' => 'qd:topic-3',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                ],
            ],
        ],
        'header' => [
            'name' => 'ex:header',
            'type' => 'header',
            'passive' => false,
            'durable' => false,
            'auto_delete' => true,
            'internal' => false,
            'nowait' => false,
            'arguments' => [],
            'ticket' => null,
            'queues' => [
                [
                    'name' => 'qd:header-1',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                ],
                [
                    'name' => 'qd:header-2',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                ],
                [
                    'name' => 'qd:header-3',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                ],
            ],
        ],
    ],
];

return $config;
