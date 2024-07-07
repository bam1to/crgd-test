<?php

declare(strict_types=1);

namespace Kernel\Routing;

use Kernel\Config;
use Kernel\Routing\Exception\RouteNotFoundException;

class Routing
{
    public function processRouting()
    {
        // check controllers
        $controllers = $this->parseControllers();

        // parse url
        $urlDto = (new UrlParser())->parseUrl();

        foreach ($controllers as $controller) {
            if ($controller->getShortName() === $urlDto->controllerName . 'Controller') {
                try {
                    $action = $controller->getMethod($urlDto->controllerAction === '' ? 'actionIndex' : 'action' . $urlDto->controllerAction);
                } catch (\ReflectionException $e) {
                    throw new RouteNotFoundException($urlDto->originalUrl . ' has not found.', 404, $e);
                }
                $controllerInstance = new ($controller->getName());
                $actionName = $action->name;
                echo $controllerInstance->$actionName();
                exit();
            }
        }
        throw new RouteNotFoundException($urlDto->originalUrl . ' has not found.', 404);
    }

    /**
     * @return array<\ReflectionClass>
     */
    private function parseControllers(): array
    {
        $controllersFolder = Config::get('base.project_root') . '/Controller';

        $classes = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($controllersFolder));

        foreach ($iterator as $file) {
            if ($file->isFile() && preg_match('/Controller\.php$/', $file->getFilename())) {
                $filePath = $file->getRealPath();

                $fileContent = file_get_contents($filePath);

                $namespace = $this->extractNamespace($fileContent);

                if (null === $namespace) {
                    return [];
                }

                if (preg_match_all('/class\s+([a-zA-Z0-9_]+)/', $fileContent, $matches)) {
                    foreach ($matches[1] as $className) {
                        try {
                            $reflectionClass = new \ReflectionClass($namespace . '\\' . $className);

                            $classes[] = $reflectionClass;
                        } catch (\ReflectionException $e) {
                            return [];
                        }
                    }
                }
            }
        }

        return $classes;
    }

    private function extractNamespace(string $fileContent): ?string
    {
        $namespacePattern = '/namespace\s+([^;]+);/';

        // Ищем совпадения
        if (preg_match($namespacePattern, $fileContent, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }
}
