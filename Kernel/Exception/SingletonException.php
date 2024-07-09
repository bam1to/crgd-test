<?php

declare(strict_types=1);

namespace Kernel\Exceptions;

class SingletonException extends \Exception
{
    protected $message = 'Singleton operation not allowed.';
}
