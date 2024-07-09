<?php

declare(strict_types=1);

namespace Kernel\Database\Exception;

class ConnectionException extends \PDOException
{
    protected $message = 'Database connection error.';
}
