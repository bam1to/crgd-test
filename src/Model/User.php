<?php

declare(strict_types=1);

namespace App\Model;

class User
{
    public function __construct(
        public int $userId,
        public string $username,
        public string $password
    ) {
    }
}
