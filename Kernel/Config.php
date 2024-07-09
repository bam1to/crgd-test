<?php

declare(strict_types=1);

namespace Kernel;

use Kernel\Exception\NoFileException;

class Config implements ConfigInterface
{
    private static array $config = [];

    public static function load(string $configFile): void
    {
        if (!file_exists($configFile)) {
            throw new NoFileException("Config file not found: $configFile");
        }

        static::$config = require_once $configFile;
    }

    public static function get(string $configKey, mixed $default = null): mixed
    {
        $keys = explode('.', $configKey);
        $configValue = static::$config;

        foreach ($keys as $key) {
            if (!isset($configValue[$key])) {
                return $default;
            }
            $configValue = $configValue[$key];
        }

        return $configValue;
    }
}
