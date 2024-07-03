<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Kernel\Database\PgDatabase;

class Kernel
{
    public function bootstrap()
    {
        // init config
        Config::load('/config/params.php');

        // init database (here can be a builder for different databases)
        PgDatabase::getInstance();

        // process routing
    }
}
