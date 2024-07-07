<?php

declare(strict_types=1);

namespace Kernel\Session;

interface SessionInterface
{
    /**
     * Sets new value to session key
     */
    public function set(mixed $key, mixed $value): void;

    /**
     * Gets value by session key, sets default if didn't find any
     */
    public function get(mixed $key, mixed $default = null): mixed;

    /**
     * Checks whether value exists for session key or not
     */
    public function has(mixed $key): bool;

    /**
     * Removes value by key
     */
    public function remove(mixed $key): void;

    /**
     * Clears the session
     */
    public function clear(): void;

    /**
     * Destroys the session
     */
    public function destroy(): void;
}
