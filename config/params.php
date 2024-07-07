<?php

return [
    'base' => [
        'project_root' => dirname(__DIR__) . '/src',
        'kernel_root' => dirname(__DIR__) . '/Kernel'
    ],
    'url' => [
        'homepage' => [
            'before_login' => '/admin/login',
            'after_login' => '/admin/dashboard'
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
