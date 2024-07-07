<?php

declare(strict_types=1);

namespace Kernel;

use Kernel\Database\DatabaseBuilder;
use Kernel\Routing\Routing;

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
            (new Routing())->processRouting();
        } catch (\Exception $e) {
            print_r($e->getMessage());
        } catch (\Error $e) {
            print_r($e->getMessage());
        } finally {
            die();
        }
    }
}
