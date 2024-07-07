<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\IncomeNewsDto;
use Kernel\Config;
use Kernel\Controller;
use App\Exception\AuthenticationException;
use App\Repository\NewsRepository;
use App\Service\Auth;

class AdminController extends Controller
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
        if (
            isset($_POST['_username']) && $_POST['_username'] !== ''
            && isset($_POST['_password']) && $_POST['_password'] !== ''
        ) {
            try {
                $this->authService->login($_POST['_username'], $_POST['_password']);

                $this->redirect(Config::get('url.homepage.after_login'));
            } catch (AuthenticationException $e) {
                $error = $e->getMessage();
            }
        }

        return $this->render('login.html.twig', ['error' => $error]);
    }

    public function actionDashboard(): string
    {
        if (!$this->authService->isAuthenticated()) {
            $this->redirect(Config::get('url.homepage.before_login'));
        }

        $newsRepository = new NewsRepository();
        $newsList = $newsRepository->findAllNews();

        return $this->twig->render('dashboard.html.twig', ['newsList' => $newsList]);
    }

    public function actionNewsCreate()
    {
        $newsTitle = $_POST['_title'];
        $newsDescription = $_POST['_description'];

        (new NewsRepository())->createNews(new IncomeNewsDto($newsTitle, $newsDescription));

        return json_encode('done');
    }

    public function actionLogout(): void
    {
        $this->authService->logout();
        $this->redirect(Config::get('url.homepage.before_login'));
    }
}
