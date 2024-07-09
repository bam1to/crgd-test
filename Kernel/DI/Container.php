<?php

declare(strict_types=1);

namespace Kernel\DI;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    private array $bindings = [];
    private array $instances = [];

    public function set(string $id, callable $concrete)
    {
        $this->bindings[$id] = $concrete;
    }

    public function get(string $id): callable
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (isset($this->bindings[$id])) {
            $this->instances[$id] = $this->bindings[$id]($this);
            return $this->instances[$id];
        }

        throw new class extends \Exception implements NotFoundExceptionInterface
        {
        };
    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]) || isset($this->instances[$id]);
    }
}
