<?php

declare(strict_types=1);

namespace Kernel\Routing;

use Kernel\Routing\Exception\RouteNotFoundException;

interface RoutingInterface
{
    /**
     * @throws RouteNotFoundException
     */
    public function processRouting(): void;
}
