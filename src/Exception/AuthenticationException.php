<?php

declare(strict_types=1);

namespace App\Exception;

class AuthenticationException extends \Exception
{
    public function __construct($message = "Wrong Login Data!", $code = 401, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
