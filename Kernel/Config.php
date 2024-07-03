<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Kernel\Exception\NoFileException;

class Config
{
    private static array $config = [];

    /**
     * @throws NoFileException
     */
    public static function load(string $configFile): void
    {
        if (file_exists($configFile)) {
            static::$config = require_once $configFile;
        } else {
            throw new NoFileException();
        }
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
