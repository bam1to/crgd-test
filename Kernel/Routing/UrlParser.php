<?php

declare(strict_types=1);

namespace Kernel\Routing;

use Kernel\Routing\Dto\UrlDto;

/**
 * We create only two-dimensional url system.
 * Of course this approach cannot be used in production
 */
class UrlParser
{
    public function parseUrl(): ?UrlDto
    {
        $requestUri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $parsedUrl = parse_url($requestUri);

        $path = $parsedUrl['path'] ?? '';
        $parts = explode('/', trim($path, '/'));

        if (empty($parts)) {
            return null;
        }

        $controllerName = $this->toCamelCase($parts[0]);

        $actionParts = array_slice($parts, 1);
        $action = $this->toCamelCase(implode('-', $actionParts));

        return new UrlDto($requestUri, $controllerName, $action);
    }

    private function toCamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
    }
}
