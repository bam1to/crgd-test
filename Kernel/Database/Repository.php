<?php

declare(strict_types=1);

namespace Kernel\Database;

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

    public function findOne(string $query = "", array $params = []): array|false
    {
        try {
            $statement = $this->database->getStatement($query, $params);
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
            // TODO: add exception handler
        }
    }

    public function findAll(string $query = "", array $params = []): array|false
    {
        try {
            $statement = $this->database->getStatement($query, $params);
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
            // TODO: add exception handler
        }
    }

    public function insert(string $query = "", array $params = []): array|false
    {
        try {
            $statement = $this->database->getStatement($query, $params);
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
            // TODO: add exception handler
        }
    }

    public function update(string $query = "", array $params = []): bool
    {
        try {
            return $this->database->getStatement($query, $params)->rowCount() > 0;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
            // TODO: add exception handler
        }
    }

    protected function delete(string $query = "", array $params = []): bool
    {
        try {
            return $this->database->getStatement($query, $params)->rowCount() > 0;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
            // TODO: add exception handler
        }
    }

    protected function getLastInsertedIndex(): string
    {
        $lastInsertedIndex = $this->database->getLastInsertedIndex();

        if (!$lastInsertedIndex) {
            throw new \Exception("Cannot found last inserted index");
        }

        return $lastInsertedIndex;
    }
}
