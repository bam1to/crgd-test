<?php

declare(strict_types=1);

namespace Kernel\Database;

interface DatabaseInterface
{
    public function getStatement(string $query, array $params): \PDOStatement;
}
