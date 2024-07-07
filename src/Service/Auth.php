<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\AuthenticationException;
use App\Repository\UserRepository;
use Kernel\Session\Session;
use Kernel\Session\SessionInterface;

class Auth
{
    private readonly UserRepository $userRepository;
    private readonly SessionInterface $session;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->session = new Session();
    }

    /**
     * @throws AuthenticationException
     */
    public function login(string $username, string $password): void
    {

        $username = htmlspecialchars(trim($username));
        $password = htmlspecialchars(trim($password));

        $user = $this->userRepository->findByUsername($username);

        if (!$user || !password_verify($password, $user->password)) {
            throw new AuthenticationException();
        }

        $this->session->set('user_id', $user->userId);
    }

    public function logout(): void
    {
        $this->session->remove('user_id');
    }

    public function isAuthenticated(): bool
    {
        return $this->session->has('user_id');
    }
}
