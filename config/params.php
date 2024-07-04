<?php

return [
    'base' => [
        'project_root' => __DIR__ . '/src',
        'kernel_root' => __DIR__ . '/Kernel'
    ],
    'database' => [
        'type' => 'pgsql',
        'dsn' => 'pgsql:host=127.0.0.1;port=5432;dbname=postgres',
        'username' => 'postgres',
        'password' => 'password'
    ],
    'twig' => [
        'twig_path' => '/web'
    ]
];
