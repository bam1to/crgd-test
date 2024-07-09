<?php

declare(strict_types=1);

namespace Kernel\Database;

use Kernel\Config;
use Kernel\Database\Exception\ConnectionException;
use Kernel\Database\Exceptions\DatabaseException;

class PgDatabase extends Database implements DatabaseInterface
{
    private readonly \PDO $pdoConnection;

    protected function __construct()
    {
        try {
            $this->pdoConnection = new \PDO(
                dsn: Config::get('database.dsn'),
                username: Config::get('database.username'),
                password: Config::get('database.password')
            );
        } catch (\PDOException $e) {
            throw new ConnectionException('Cannot establish connection', $e->getCode(), $e);
        }
    }

    public function getStatement(string $query, array $params): \PDOStatement
    {
        return $this->prepareStatement($query, $params);
    }

    public function getLastInsertedIndex(): string|false
    {
        return $this->pdoConnection->lastInsertId();
    }

    /**
     * @throws DatabaseException
     */
    private function prepareStatement(string $query, array $params): \PDOStatement
    {
        try {
            $statement = $this->pdoConnection->prepare($query);

            if ($statement === false) {
                throw new DatabaseException('Cannot prepare statement for: ' . $query);
            }

            foreach ($params as $key => $param) {
                $statement->bindValue($key, $param);
            }

            $statement->execute();

            return $statement;
        } catch (\PDOException $pdoException) {
            throw new DatabaseException('Cannot prepare statement for: ' . $query, $pdoException->getCode(), $pdoException);
        }
    }
}
