<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\IncomeNewsDto;
use App\Model\News;
use Kernel\Database\Repository;

class NewsRepository extends Repository
{
    public function createNews(IncomeNewsDto $newsDto): void
    {
        $createdNews = $this->insert('INSERT INTO news (news_title, news_description) VALUES (:title, :description)', [
            'title' => $newsDto->title,
            'description' => $newsDto->description
        ]);
    }

    public function findAllNews(): array
    {
        $newsList = $this->findAll('SELECT news_id, news_title, news_description FROM news');
        $newsListDto = [];

        foreach ($newsList as $news) {
            $newsListDto[] = new News($news['news_id'], $news['news_title'], $news['news_description']);
        }

        return $newsListDto;
    }
}
