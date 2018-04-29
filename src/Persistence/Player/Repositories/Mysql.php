<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Player\Repositories;

use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\PlayerRepository;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
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
        $dto = $player->toDTO();

        $sql = <<<SQL
            INSERT INTO player (uuid, name)
            VALUES (:uuid, :name)
SQL;

        $statement = $this->databaseConnection->prepare($sql);
        $statement->bindValue(':uuid', $dto->uuid());
        $statement->bindValue(':name', $dto->name());
        $statement->execute();
    }

    public function findById(string $id): ?Player
    {
        return null;
    }

    public function findAll(): iterable
    {
        $sql = 'SELECT * FROM player';

        $statement = $this->databaseConnection->prepare($sql);
        $statement->execute();

        $players = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result)
        {
            $players[] = $this->buildDomainObject($result);
        }

        return $players;
    }

    private function buildDomainObject(array $result): Player
    {
        return new Player(
            new Uuid($result['uuid']),
            $result['name']
        );
    }
}
