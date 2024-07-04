<?php

declare(strict_types=1);

namespace Kernel\Database;

use Kernel\Config;
use Kernel\Database\Exception\WrongDatabaseTypeException;

class DatabaseBuilder
{
    public static function getDatabase()
    {
        return match (Config::get('database.type')) {
            'pgsql' => PgDatabase::getInstance(),
            default => throw new WrongDatabaseTypeException()
        };
    }
}
