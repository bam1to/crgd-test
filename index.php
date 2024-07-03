<?php

declare(strict_types=1);
phpinfo();
die;

use App\Kernel\Kernel;

require_once './vendor/autoload.php';


(new Kernel())->bootstrap();
