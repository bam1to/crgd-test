<?php

declare(strict_types=1);

namespace App\Controller;

use Kernel\Config;
use Kernel\Controller;
use App\Exception\AuthenticationException;
use App\Service\Auth;

class AuthController extends Controller
{
    private readonly Auth $authService;

    public function __construct()
    {
        $this->authService = new Auth();

        parent::__construct();
    }

    public function actionLogin(): string
    {
        if ($this->authService->isAuthenticated()) {
            $this->redirect(Config::get('url.homepage.after_login'));
        }

        $error = '';
        if ($this->isPostRequest() && $this->hasValidCredentials()) {
            try {
                $this->authService->login($_POST['_username'], $_POST['_password']);

                $this->redirect(Config::get('url.homepage.after_login'));
            } catch (AuthenticationException $e) {
                $error = $e->getMessage();
            }
        }

        return $this->render('login.html.twig', ['error' => $error]);
    }

    public function actionLogout(): void
    {
        $this->authService->logout();
        $this->redirect(Config::get('url.homepage.before_login'));
    }

    private function hasValidCredentials(): bool
    {
        return !empty($_POST['_username']) && !empty($_POST['_password']);
    }
}
