<?php

declare(strict_types=1);

namespace App\Dto;

readonly class IncomeNewsDto
{
    public function __construct(
        public string $title,
        public string $description,
        public int $id = 0
    ) {
    }
}
