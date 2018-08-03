<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Core;

trait MysqlTrait
{
    private
        $databaseConnection;

    public function startTransaction(): void
    {
        $this->databaseConnection->beginTransaction();
    }

    public function commitTransaction(): void
    {
        $this->databaseConnection->commit();
    }

    public function rollbackTransaction(): void
    {
        $this->databaseConnection->rollback();
    }
}
