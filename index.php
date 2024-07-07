<?php

declare(strict_types=1);

use Kernel\Kernel;

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    throw new \RuntimeException('Autoload file not found. Please run "composer install".');
}
require_once $autoloadPath;

(new Kernel())->bootstrap();
