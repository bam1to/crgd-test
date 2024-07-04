<?php

declare(strict_types=1);

namespace App\Kernel\Database;

class Database
{
    private static ?Database $instance = null;

    protected function __construct()
    {
    }

    public function __clone()
    {
        throw new \Exception('Database object cannot be cloned');
    }

    public function __wakeup()
    {
        throw new \Exception('Cannot be unserialized');
    }

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
