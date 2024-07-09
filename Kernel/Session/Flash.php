<?php

declare(strict_types=1);

namespace Kernel\Session;

class Flash
{
    private string $flashKey = '_flash';

    public function __construct(private readonly SessionInterface $session)
    {
    }

    public function set(mixed $key, mixed $value): void
    {
        $flashes = $this->session->get($this->flashKey, []);
        $flashes[$key] = $value;
        $this->session->set($this->flashKey, $flashes);
    }

    public function get(mixed $key, mixed $default = null): mixed
    {
        $flashes = $this->session->get($this->flashKey, []);
        $value = isset($flashes[$key]) ? $flashes[$key] : $default;
        $this->clear($key);
        return $value;
    }

    public function has(mixed $key): bool
    {
        $flashes = $this->session->get($this->flashKey, []);
        return isset($flashes[$key]);
    }

    private function clear(mixed $key): void
    {
        $flashes = $this->session->get($this->flashKey, []);
        if (isset($flashes[$key])) {
            unset($flashes[$key]);
            $this->session->set($this->flashKey, $flashes);
        }
    }

    public function clearAll(): void
    {
        $this->session->remove($this->flashKey);
    }
}
