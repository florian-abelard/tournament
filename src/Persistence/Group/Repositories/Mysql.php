<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Group\Repositories;

use Doctrine\DBAL\Statement;
use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\ValueObjects\RankingPoints;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlCore;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\Entities\Group;
use Flo\Tournoi\Domain\Group\GroupRepository;

class Mysql extends MysqlCore implements GroupRepository
{
    private const
        TABLE = 'group',
        PLAYER_JOIN_TABLE = 'group_player',
        PLAYER_TABLE = 'player';

    public function persist(Group $group): void
    {
        $table = self::TABLE;
        $dto = $group->toDTO();

        $sql = <<<SQL
            INSERT INTO `$table` (uuid, stage_uuid, label, places_number)
            VALUES (:uuid, :stageUuid, :label, :numberOfPlaces)
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $dto->uuid());
        $statement->bindValue(':stageUuid', $dto->stageUuid());
        $statement->bindValue(':label', $dto->label());
        $statement->bindValue(':numberOfPlaces', $dto->numberOfPlaces());
        $statement->execute();

        foreach ($group->players() as $player)
        {
            $this->addPlayer($group->uuid(), $player);
        }
    }

    public function addPlayer(Uuid $uuid, Player $player): void
    {
        $table = self::PLAYER_JOIN_TABLE;
        $playerDto = $player->toDTO();

        $sql = <<<SQL
            INSERT INTO $table (group_uuid, player_uuid)
            VALUES (:groupUuid, :playerUuid)
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':groupUuid', $uuid->value());
        $statement->bindValue(':playerUuid', $playerDto->uuid());
        $statement->execute();
    }

    public function findByStageId(Uuid $stageUuid): GroupCollection
    {
        $table = self::TABLE;
        $joinTable = self::PLAYER_JOIN_TABLE;
        $playerTable = self::PLAYER_TABLE;

        $sql = <<<SQL
            SELECT gr.*, gp.player_uuid, pl.name, pl.ranking_points
            FROM `$table` as gr
            INNER JOIN `$joinTable` as gp
            ON gr.uuid = gp.group_uuid
            INNER JOIN `$playerTable` as pl
            ON gp.player_uuid = pl.uuid
            WHERE stage_uuid = :stageUuid
            ORDER BY pl.ranking_points DESC
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':stageUuid', $stageUuid->value());
        $statement->execute();

        $resultGroupedBy = $this->groupsResultByGroup($statement);

        $groups = $this->buildCollection($resultGroupedBy);

        return $groups;
    }

    public function buildCollection(array $resultGroupedBy): GroupCollection
    {
        $groups = new GroupCollection();

        foreach ($resultGroupedBy as $groupUuid => $resultByGroup)
        {
            $group = $this->buildDomainObject($resultByGroup[0]);

            foreach ($resultByGroup as $result)
            {
                $group->addPlayer(
                    $this->buildPlayerDomainObject($result)
                );
            }

            $groups->add($group);
        }

        return $groups;
    }

    public function buildDomainObject(array $result): Group
    {
        $group = new Group(
            new Uuid($result['uuid']),
            new Uuid($result['stage_uuid'])
        );
        $group->setLabel($result['label']);
        $group->setNumberOfPlaces((int) $result['places_number']);

        return $group;
    }

    public function buildPlayerDomainObject(array $result): Player
    {
        $player = new Player(
            new Uuid($result['player_uuid']),
            $result['name']
        );

        $player->setRankingPoints(new RankingPoints($result['ranking_points']));

        return $player;
    }

    public function groupsResultByGroup(Statement $statement): array
    {
        $groupedBy = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result)
        {
            $groupedBy[$result['uuid']][] = $result;
        }

        return $groupedBy;
    }
}
