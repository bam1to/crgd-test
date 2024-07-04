<?php

declare(strict_types=1);

namespace App\Kernel\Database;

use App\Kernel\Config;
use App\Kernel\Database\Exception\WrongDatabaseTypeException;

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
