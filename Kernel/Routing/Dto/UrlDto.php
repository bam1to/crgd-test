<?php

declare(strict_types=1);

namespace Kernel\Routing\Dto;

readonly class UrlDto
{
    public function __construct(
        public string $originalUrl,
        public string $controllerName,
        public string $controllerAction
    ) {
    }
}
