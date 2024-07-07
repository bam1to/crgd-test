<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\User;
use Kernel\Database\Repository;

class UserRepository extends Repository
{
    /**
     * @var User[] $users
     */
    public readonly array $users;

    public function __construct()
    {
        $this->users = [
            new User(1, 'admin', password_hash('test', PASSWORD_DEFAULT))
        ];
    }

    /**
     * @return User
     */
    public function findByUsername(string $username): ?User
    {
        foreach ($this->users as $user) {
            if ($user->username === $username) {
                return $user;
            }
        }

        return null;
    }
}
