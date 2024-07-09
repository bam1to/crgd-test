<?php

declare(strict_types=1);

namespace Kernel\DI;

interface ServiceProviderInterface
{
    public function register(Container $container): void;
}
