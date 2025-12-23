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
                    'name' => 'q:fanout-1',
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
                    'name' => 'q:fanout-2',
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
                    'name' => 'q:fanout-3',
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
                    'name' => 'q:direct-1',
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
                    'name' => 'q:direct-2',
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
                    'name' => 'q:direct-3',
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
            // test with message key: "convert.image.jpg"
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
                    'name' => 'q:topic-1',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                    'bindings' => [
                        [
                            'routing_key' => '*.image.*',
                            'arguments' => [],
                        ],
                    ],
                ],
                [
                    'name' => 'q:topic-2',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                    'bindings' => [
                        [
                            'routing_key' => '#.image',
                            'arguments' => [],
                        ],
                    ],
                ],
                [
                    'name' => 'q:topic-3',
                    'passive' => false,
                    'durable' => true,
                    'exclusive' => false,
                    'auto_delete' => false,
                    'nowait' => false,
                    'arguments' => [],
                    'ticket' => null,
                    'bindings' => [
                        [
                            'routing_key' => '#.jpg',
                            'arguments' => [],
                        ],
                    ],
                ],
            ],
        ],
        'headers' => [
            // test with message key: "convert.image.bmp"
            'name' => 'ex:headers',
            'type' => 'headers',
            'passive' => false,
            'durable' => false,
            'auto_delete' => true,
            'internal' => false,
            'nowait' => false,
            'arguments' => [],
            'ticket' => null,
            'queues' => [
                [
                    'name' => 'q:header-1',
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
                            'arguments' => [
                                'x-match' => 'all',
                                'job' => 'convert',
                                'format' => 'jpg',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'q:header-2',
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
                            'arguments' => [
                                'x-match' => 'any',
                                'job' => 'convert',
                                'format' => 'jpg',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'q:header-3',
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
                            'arguments' => [
                                'x-match' => 'any',
                                'job' => 'convert',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];

return $config;
