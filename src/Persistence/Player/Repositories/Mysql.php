<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Player\Repositories;

use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlAbstract;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\PlayerRepository;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;

class Mysql extends MysqlAbstract implements PlayerRepository
{
    private const
        TABLE = 'player';

    public function persist(Player $player): void
    {
        $dto = $player->toDTO();

        $sql = <<<SQL
            INSERT INTO player (uuid, name)
            VALUES (:uuid, :name)
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $dto->uuid());
        $statement->bindValue(':name', $dto->name());
        $statement->execute();
    }

    public function findById(Uuid $uuid): ?Player
    {
        return null;
    }

    public function findAll(): iterable
    {
        $sql = 'SELECT * FROM ' . self::TABLE;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->execute();

        $players = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result)
        {
            $players[] = $this->buildDomainObject($result);
        }

        return $players;
    }

    public function findByTournamentId(Uuid $tournamentUuid): iterable
    {
        $table = self::TABLE;

        $sql = <<<SQL
            SELECT p.*
            FROM $table as p
            INNER JOIN tournament_player
            ON p.uuid = tournament_player.player_uuid
            WHERE tournament_player.tournament_uuid = :tournamentUuid
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':tournamentUuid', $tournamentUuid);
        $statement->execute();

        $players = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result)
        {
            $players[] = $this->buildDomainObject($result);
        }

        return $players;
    }

    public function remove(Uuid $uuid): void
    {
        $table = self::TABLE;

        $sql = <<<SQL
            DELETE FROM $table
            WHERE uuid = :uuid
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $uuid->value());
        $statement->execute();
    }

    protected function buildDomainObject(array $result): Player
    {
        return new Player(
            new Uuid($result['uuid']),
            $result['name']
        );
    }
}
