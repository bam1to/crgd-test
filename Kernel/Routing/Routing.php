<?php

declare(strict_types=1);

namespace Kernel\Routing;

use Kernel\Config;
use Kernel\Routing\Dto\UrlDto;
use Kernel\Routing\Exception\RouteNotFoundException;

class Routing implements RoutingInterface
{
    public function processRouting(): void
    {
        $controllers = $this->parseControllers();
        $urlDto = (new UrlParser())->parseUrl();

        foreach ($controllers as $controller) {
            if ($controller->getShortName() === $urlDto->controllerName . 'Controller') {
                $this->executeAction($controller, $urlDto);
                return;
            }
        }
        throw new RouteNotFoundException($urlDto->originalUrl . ' has not found.', 404);
    }

    private function executeAction(\ReflectionClass $controller, UrlDto $urlDto): void
    {
        try {
            $action = $controller->getMethod(
                $urlDto->controllerAction === '' ? 'actionIndex' : 'action' . ucfirst($urlDto->controllerAction)
            );
        } catch (\ReflectionException $e) {
            throw new RouteNotFoundException($urlDto->originalUrl . ' not found.', 404, $e);
        }

        $controllerInstance = $controller->newInstance();
        $actionName = $action->getName();
        echo $controllerInstance->$actionName();
        exit();
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
                $className = $this->getClassName($file->getRealPath());
                if ($className) {
                    $classes[] = $className;
                }
            }
        }

        return $classes;
    }

    private function getClassName(string $filePath): ?\ReflectionClass
    {
        $fileContent = file_get_contents($filePath);
        $namespace = $this->extractNamespace($fileContent);

        if ($namespace && preg_match('/class\s+([a-zA-Z0-9_]+)/', $fileContent, $matches)) {
            $fullClassName = $namespace . '\\' . $matches[1];
            try {
                return new \ReflectionClass($fullClassName);
            } catch (\ReflectionException $e) {
                return null;
            }
        }

        return null;
    }

    private function extractNamespace(string $fileContent): ?string
    {
        if (preg_match('/namespace\s+([^;]+);/', $fileContent, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }
}
