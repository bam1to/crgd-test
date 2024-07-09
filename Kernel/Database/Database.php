<?php

declare(strict_types=1);

namespace Kernel\Database;

use Kernel\Exceptions\SingletonException;

class Database
{
    private static ?Database $instance = null;

    protected function __construct()
    {
    }

    public function __clone()
    {
        throw new SingletonException('Database object cannot be cloned');
    }

    public function __wakeup()
    {
        throw new SingletonException('Cannot be unserialized');
    }

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
