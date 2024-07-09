<?php

return [
    'base' => [
        'project_root' => dirname(__DIR__) . '/src',
        'kernel_root' => dirname(__DIR__) . '/Kernel'
    ],
    'url' => [
        'homepage' => [
            'before_login' => '/auth/login',
            'after_login' => '/news/dashboard'
        ],
    ],
    'database' => [
        'type' => 'pgsql',
        'dsn' => 'pgsql:host=127.0.0.1;port=5432;dbname=postgres',
        'username' => 'postgres',
        'password' => 'password'
    ],
    'twig' => [
        'twig_path' => dirname(__DIR__) . '/src/View'
    ]
];
