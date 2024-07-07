<?php

declare(strict_types=1);

namespace App\Model;

class News
{
    public function __construct(
        public int $newsId,
        public string $title,
        public string $description
    ) {
    }
}
