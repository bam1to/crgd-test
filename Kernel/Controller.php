<?php

declare(strict_types=1);

namespace Kernel;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;

class Controller
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(Config::get('twig.twig_path'));
        $this->twig = new Environment($loader);
    }

    protected function render(string|TemplateWrapper $name, array $params): string
    {
        return $this->twig->render($name, $params);
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit();
    }

    protected function isPostRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
