<?php

declare(strict_types=1);

namespace App\Model;

use JsonSerializable;

class User implements JsonSerializable
{
    public function __construct(
        public int $userId,
        public string $username,
        public string $password
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
