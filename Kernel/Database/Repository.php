<?php

declare(strict_types=1);

namespace Kernel\Database;

use Kernel\Database\Exceptions\DatabaseException;

/**
 * Base class for all repositories
 */
class Repository
{
    private readonly DatabaseInterface $database;

    public function __construct()
    {
        $this->database = DatabaseBuilder::getDatabase();
    }

    public function findOne(string $query, array $params = []): array|false
    {
        return $this->executeQuery($query, $params)->fetch(\PDO::FETCH_ASSOC);
    }

    public function findAll(string $query, array $params = []): array|false
    {
        return $this->executeQuery($query, $params)->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function getLastInsertedIndex(): string
    {
        $lastInsertedIndex = $this->database->getLastInsertedIndex();

        if (!$lastInsertedIndex) {
            throw new DatabaseException("Cannot found last inserted index");
        }

        return $lastInsertedIndex;
    }

    public function execute(string $query, array $params): bool
    {
        return $this->executeQuery($query, $params)->rowCount() > 0;
    }

    private function executeQuery(string $query, array $params): \PDOStatement
    {
        try {
            return $this->database->getStatement($query, $params);
        } catch (\Exception $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
