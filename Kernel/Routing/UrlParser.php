<?php

declare(strict_types=1);

namespace Kernel\Routing;

use Kernel\Config;
use Kernel\Routing\Dto\UrlDto;

/**
 * We create only two-dimensional url system.
 * Of course this approach cannot be used in production
 */
class UrlParser
{
    public function parseUrl(): ?UrlDto
    {
        $requestUri = $this->sanitizeUrl($_SERVER['REQUEST_URI'] ?? '');
        $parsedUrl = parse_url($requestUri);

        $path = $parsedUrl['path'] ?? '';
        $path = $path === '/' ? Config::get('url.homepage.before_login') : $path;
        $parts = explode('/', trim($path, '/'));

        if (empty($parts)) {
            return null;
        }

        $controllerName = $this->toCamelCase($parts[0]);

        $actionParts = array_slice($parts, 1);
        $action = $this->toCamelCase(implode('-', $actionParts));

        return new UrlDto($requestUri, $controllerName, $action);
    }

    private function sanitizeUrl(string $url): string
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    private function toCamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
    }
}
