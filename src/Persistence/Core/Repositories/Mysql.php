<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Core\Repositories;

use Doctrine\DBAL\Connection;
use Flo\Tournoi\Persistence\Core\MysqlTrait;

abstract class Mysql
{
    use MysqlTrait;
    
    public function __construct(Connection $connection)
    {
        $this->databaseConnection = $connection;
    }

    protected function getDatabaseConnection(): Connection
    {
        return $this->databaseConnection;
    }
}
