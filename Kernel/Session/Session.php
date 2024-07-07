<?php

declare(strict_types=1);

namespace Kernel\Session;

class Session implements SessionInterface
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set(mixed $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(mixed $key, mixed $default = null): mixed
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public function has(mixed $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(mixed $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function clear(): void
    {
        session_unset();
    }

    public function destroy(): void
    {
        session_destroy();
    }
}
