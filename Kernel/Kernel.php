<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Kernel\Database\DatabaseBuilder;
use App\Kernel\Database\Model;

class Kernel
{
    public function bootstrap()
    {
        try {
            // init config
            Config::load(__DIR__ . '/../config/params.php');

            // init database (here can be a builder for different databases)
            DatabaseBuilder::getDatabase();

            // process routing

        } catch (\Exception $e) {
            print_r($e->getMessage());
            die;
        }
    }
}
