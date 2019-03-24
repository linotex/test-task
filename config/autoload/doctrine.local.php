<?php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'driver'   => 'pdo_mysql',
                    'host'     => 'mysql_m',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => '123',
                    'dbname'   => 'school',
                ],
            ],
        ],
        'driver' => [
            'application' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../../module/Application/src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'application',
                ]
            ]
        ],
    ]
];
