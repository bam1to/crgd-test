<?php

declare(strict_types=1);

namespace Kernel;

interface ConfigInterface
{
    /**
     * Load configuration from a file
     * 
     * @param string $configFile
     * @throws NoFileException
     */
    public static function load(string $configFile): void;

    /**
     * Get a configuration value
     * 
     * @param string $configKey
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $configKey, mixed $default = null): mixed;
}
