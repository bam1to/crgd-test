<?php

declare(strict_types=1);

namespace App\Kernel\Exception;

class NoFileException extends \Exception
{
    public function __construct(string $message = "File doesn't exist", int $code = 0, \Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
