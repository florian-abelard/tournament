<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Player\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\PlayerRepository;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\ValueObjects\RankingPoints;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlCore;

class Mysql extends MysqlCore implements PlayerRepository
{
    private const
        TABLE = 'player';

    public function persist(Player $player): void
    {
        $dto = $player->toDTO();

        $sql = <<<SQL
            INSERT INTO player (uuid, name, ranking_points)
            VALUES (:uuid, :name, :rankingPoints)
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $dto->uuid());
        $statement->bindValue(':name', $dto->name());
        $statement->bindValue(':rankingPoints', $dto->rankingPoints());
        $statement->execute();
    }

    public function findById(Uuid $uuid): ?Player
    {
        $table = self::TABLE;

        $sql = <<<SQL
            SELECT * FROM $table
            WHERE uuid = :uuid
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $uuid->value());
        $statement->execute();

        if ($statement->rowCount() === 0)
        {
            return null;
        }

        $result = $statement->fetch();
        $player = $this->buildDomainObject($result);

        return $player;
    }

    public function findAll(): PlayerCollection
    {
        $sql = 'SELECT * FROM ' . self::TABLE;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->execute();

        $players = new PlayerCollection;
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result)
        {
            $players->add($this->buildDomainObject($result));
        }

        return $players;
    }

    public function findByTournamentId(Uuid $tournamentUuid): PlayerCollection
    {
        $table = self::TABLE;

        $sql = <<<SQL
            SELECT p.*
            FROM $table as p
            INNER JOIN registration as r
            ON p.uuid = r.player_uuid
            WHERE r.tournament_uuid = :tournamentUuid
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':tournamentUuid', $tournamentUuid);
        $statement->execute();

        $players = new PlayerCollection;
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result)
        {
            $players->add($this->buildDomainObject($result));
        }

        return $players;
    }

    public function findNotInTournament(Uuid $tournamentUuid): PlayerCollection
    {
        $table = self::TABLE;

        $sql = <<<SQL
            SELECT *
            FROM $table
            WHERE uuid NOT IN (
                SELECT player_uuid
                FROM registration as r
                WHERE r.tournament_uuid = :tournamentUuid
            )
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':tournamentUuid', $tournamentUuid);
        $statement->execute();

        $players = new PlayerCollection;
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result)
        {
            $players->add($this->buildDomainObject($result));
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

    public function buildDomainObject(array $result): Player
    {
        $player = new Player(
            new Uuid($result['uuid']),
            $result['name']
        );

        $player->setRankingPoints(RankingPoints::fromString($result['ranking_points']));

        return $player;
    }
}
