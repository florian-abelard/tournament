<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Group\Repositories;

use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlCore;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\Entities\Group;
use Flo\Tournoi\Domain\Group\GroupRepository;

class Mysql extends MysqlCore implements GroupRepository
{
    private const
        TABLE = 'group';

    public function persist(Group $group): void
    {
        $table = self::TABLE;
        $dto = $group->toDTO();

        $sql = <<<SQL
            INSERT INTO `$table` (uuid, stage_uuid, label, places_number)
            VALUES (:uuid, :stageUuid, :label, :placesNumber)
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $dto->uuid());
        $statement->bindValue(':stageUuid', $dto->stageUuid());
        $statement->bindValue(':label', $dto->label());
        $statement->bindValue(':placesNumber', $dto->placesNumber());
        $statement->execute();

        foreach ($group->players() as $player)
        {
            $this->addPlayer($group->uuid(), $player);
        }
    }

    public function addPlayer(Uuid $uuid, Player $player): void
    {
        $table = 'group_player';
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
        return new GroupCollection();
    }
}
