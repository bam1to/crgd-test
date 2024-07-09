<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\IncomeNewsDto;
use App\Model\News;
use Kernel\Database\Repository;

class NewsRepository extends Repository
{
    public function createNews(IncomeNewsDto $newsDto): News
    {
        $this->execute('INSERT INTO news (news_title, news_description) VALUES (:title, :description)', [
            'title' => $newsDto->title,
            'description' => $newsDto->description
        ]);

        $insertedRow = $this->findOne('SELECT news_id, news_title, news_description FROM news WHERE news_id = :id', [
            'id' => $this->getLastInsertedIndex()
        ]);

        return new News(
            newsId: $insertedRow['news_id'],
            title: $insertedRow['news_title'],
            description: $insertedRow['news_description']
        );
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

    public function updateNews(IncomeNewsDto $newsDto): bool
    {
        return $this->execute('UPDATE news SET news_title = :news_title, news_description = :news_description WHERE news_id = :news_id', [
            'news_title' => $newsDto->title,
            'news_description' => $newsDto->description,
            'news_id' => $newsDto->id
        ]);
    }

    public function deleteNews(int $newsId): bool
    {
        return $this->execute("DELETE FROM news WHERE news_id = :id", [
            'id' => $newsId
        ]);
    }
}
