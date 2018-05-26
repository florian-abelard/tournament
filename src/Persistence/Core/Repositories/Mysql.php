<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Core\Repositories;

use Doctrine\DBAL\Connection;

abstract class Mysql
{
    private
        $databaseConnection;

    public function __construct(Connection $connection)
    {
        $this->databaseConnection = $connection;
    }

    protected function getDatabaseConnection(): Connection
    {
        return $this->databaseConnection;
    }
}
