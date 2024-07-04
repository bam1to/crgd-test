<?php

declare(strict_types=1);

namespace Kernel\Database;

interface DatabaseInterface
{
    public function execute(): mixed;

    public function setQuery(string $query): DatabaseInterface;

    public function setParams(array $params): DatabaseInterface;
}
