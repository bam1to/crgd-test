<?php

declare(strict_types=1);

namespace Kernel\Database\Exception;

class WrongDatabaseTypeException extends \LogicException
{
    protected $message = 'Unsupported database type.';
}
