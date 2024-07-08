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
        try {
            $newsTitle = $_POST['_title'];
            $newsDescription = $_POST['_description'];

            $createdNews = (new NewsRepository())->createNews(new IncomeNewsDto($newsTitle, $newsDescription));

            http_response_code(200);
            return json_encode($createdNews);
        } catch (\Exception $e) {
            http_response_code(400);
            return json_encode($e->getMessage());
        }
    }

    public function actionNewsDelete()
    {
        try {
            $newsId = (int)$_POST['id'];

            http_response_code(200);
            return json_encode((new NewsRepository())->deleteNews($newsId));
        } catch (\Exception $e) {
            http_response_code(400);
            return json_encode($e->getMessage());
        }
    }

    public function actionLogout(): void
    {
        $this->authService->logout();
        $this->redirect(Config::get('url.homepage.before_login'));
    }
}
