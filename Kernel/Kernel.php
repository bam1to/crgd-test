<?php

declare(strict_types=1);

namespace Kernel;

use Kernel\Database\DatabaseBuilder;
use Kernel\Database\Exceptions\DatabaseException;
use Kernel\Exceptions\AppException;
use Kernel\Routing\Exceptions\RoutingException;
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
        } catch (AppException | DatabaseException | RoutingException $e) {
            $this->handleException($e);
        } catch (\Throwable $e) {
            $this->handleException($e);
        } finally {
            exit;
        }
    }

    private function handleException(\Throwable $e): void
    {
        print_r($e->getMessage());
    }
}
