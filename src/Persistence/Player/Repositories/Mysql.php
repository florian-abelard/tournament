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
        $sql = "INSERT INTO player (uuid, name)
        VALUES (" . $player->uuid() . ", " . $player->name() . ")";

        // $this->databaseConnection->executeQuery($sql);

        $statement = $this->databaseConnection->prepare($sql);
        $statement->execute();
    }

    public function findById(string $id): ?Player
    {
        return null;
    }
}
