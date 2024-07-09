<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\IncomeNewsDto;
use App\Repository\NewsRepository;
use App\Service\Auth;
use Kernel\Config;
use Kernel\Controller;

class NewsController extends Controller
{
    private readonly Auth $authService;
    private readonly NewsRepository $newsRepository;

    public function __construct()
    {
        $this->authService = new Auth();

        if (!$this->authService->isAuthenticated()) {
            $this->redirect(Config::get('url.homepage.before_login'));
        }

        parent::__construct();

        $this->newsRepository = new NewsRepository();
    }

    public function actionDashboard(): string
    {
        $newsList = $this->newsRepository->findAllNews();

        return $this->twig->render('dashboard.html.twig', ['newsList' => $newsList]);
    }

    public function actionCreate(): string
    {
        if (!$this->isPostRequest()) {
            http_response_code(405);
            return json_encode("Wrong method type");
        }

        try {
            $newsTitle = $_POST['_title'];
            $newsDescription = $_POST['_description'];

            $createdNews = $this->newsRepository->createNews(new IncomeNewsDto(
                title: $newsTitle,
                description: $newsDescription
            ));

            http_response_code(200);
            return json_encode($createdNews);
        } catch (\Exception $e) {
            http_response_code(400);
            return json_encode($e->getMessage());
        }
    }

    public function actionDelete(): string
    {
        if (!$this->isPostRequest()) {
            http_response_code(405);
            return json_encode("Wrong method type");
        }
        try {
            $newsId = (int)$_POST['id'];

            http_response_code(200);
            return json_encode($this->newsRepository->deleteNews($newsId));
        } catch (\Exception $e) {
            http_response_code(400);
            return json_encode($e->getMessage());
        }
    }

    public function actionUpdate(): string
    {
        if (!$this->isPostRequest()) {
            http_response_code(405);
            return json_encode("Wrong method type");
        }
        try {
            $newsId = (int) $_POST['_id'];
            $newsTitle = $_POST['_title'];
            $newsDescription = $_POST['_description'];

            http_response_code(200);
            $isUpdated = json_encode($this->newsRepository->updateNews(new IncomeNewsDto(
                id: $newsId,
                title: $newsTitle,
                description: $newsDescription
            )));

            if ($isUpdated) {
                return json_encode($newsId);
            } else {
                throw new \Exception("Couldn't save");
            }
        } catch (\Exception $e) {
            http_response_code(400);
            return json_encode($e->getMessage());
        }
    }
}
