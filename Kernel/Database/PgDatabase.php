<?php

declare(strict_types=1);

namespace Kernel\Database;

use Kernel\Config;
use Kernel\Database\Exception\ConnectionException;

class PgDatabase extends Database implements DatabaseInterface
{
    private readonly \PDO $pdoConnection;
    private string $query = '';
    private array $params = [];

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

    public function setQuery(string $query): self
    {
        $this->query = $query;
        return $this;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function execute(): mixed
    {
        $statement = $this->prepareStatement();
        $this->clearQuery();
        return $statement;
    }

    private function prepareStatement(): \PDOStatement
    {
        try {
            $statement = $this->pdoConnection->prepare($this->query);

            if ($statement === false) {
                throw new \Exception('Cannot prepare statement for: ' . $this->query);
            }

            foreach ($this->params as $param) {
                $statement->bindValue($param[0], $param[1], $param[2]);
            }

            $statement->execute();

            return $statement;
        } catch (\Exception $exeption) {
            throw new \Exception($exeption->getMessage());
        } catch (\PDOException $pdoException) {
            throw new \Exception('Cannot prepare statement for: ' . $this->query);
        }
    }

    private function clearQuery()
    {
        $this->query = '';
        $this->params = [];
    }
}
