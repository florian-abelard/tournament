<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Player\Repositories;

use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\PlayerRepository;
use Doctrine\DBAL\Connection;

class Mysql implements PlayerRepository
{
    private
        $databaseConnection;

    public function __construct(Connection $connection)
    {
        $this->databaseConnection = $connection;
    }

    public function persist(Player $player): void
    {
        $sql = <<<SQL
            INSERT INTO player (uuid, name)
            VALUES (:uuid, :name)
SQL;

        $statement = $this->databaseConnection->prepare($sql);
        $statement->bindValue(':uuid', $player->uuid()->value());
        $statement->bindValue(':name', $player->name());
        $statement->execute();
    }

    public function findById(string $id): ?Player
    {
        return null;
    }
}
