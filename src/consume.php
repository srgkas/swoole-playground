<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

\SwooleResearch\ConsumerConcept\SimpleConsumer::$messages = [
    [
        'data' => [
            'type' => 'test',
            'id' => 1,
            'attributes' => [
                'sleep_time' => 1,
            ],
        ],
    ],
    [
        'data' => [
            'type' => 'test',
            'id' => 2,
            'attributes' => [
                'sleep_time' => 2,
            ],
        ],
    ],
    [
        'data' => [
            'type' => 'test',
            'id' => 3,
            'attributes' => [
                'sleep_time' => 3,
            ],
        ],
    ],
];

$consumer = new \SwooleResearch\ConsumerConcept\SimpleConsumer();
$consumer->handle();
