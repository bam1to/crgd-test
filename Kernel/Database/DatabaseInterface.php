<?php

declare(strict_types=1);

namespace Kernel\Database;

interface DatabaseInterface
{
    /**
     * @throws DatabaseException
     */
    public function getStatement(string $query, array $params): \PDOStatement;

    public function getLastInsertedIndex(): string|false;
}
