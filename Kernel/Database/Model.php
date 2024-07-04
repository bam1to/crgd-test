<?php

declare(strict_types=1);

namespace Kernel\Database;

/**
 * Base class for all models
 */
class Model
{
    private readonly DatabaseInterface $database;

    public function __construct()
    {
        $this->database = DatabaseBuilder::getDatabase();
    }

    public function findOne(string $query = "", array $params = []): mixed
    {
        try {
            $statement = $this->database->setQuery($query)->setParams($params)->execute();
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // TODO: add exception handler
        }
    }

    public function findAll(string $query = "", array $params = []): array
    {
        try {
            $statement = $this->database->setQuery($query)->setParams($params)->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // TODO: add exception
        }
    }
}
