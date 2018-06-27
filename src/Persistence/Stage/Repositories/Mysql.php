<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Stage\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Stage\Collections\StageCollection;
use Flo\Tournoi\Domain\Stage\Entities\GroupStage;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlCore;
use Flo\Tournoi\Domain\Stage\Entities\Stage;
use Flo\Tournoi\Domain\Stage\StageRepository;

class Mysql extends MysqlCore implements StageRepository
{
    private const
        TABLE = 'stage';

    public function persist(Stage $stage): void
    {
        $table = self::TABLE;
        $dto = $stage->toDTO();

        $sql = <<<SQL
            INSERT INTO `$table` (uuid, tournament_uuid, type, places_number_in_group)
            VALUES (:uuid, :tournamentUuid, :type, :placesNumberInGroup)
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $dto->uuid());
        $statement->bindValue(':tournamentUuid', $dto->tournamentUuid());
        $statement->bindValue(':type', $dto->type());
        $statement->bindValue(':placesNumberInGroup', $dto->placesNumberInGroup());
        $statement->execute();
    }

    public function findById(Uuid $uuid): ?Stage
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
        $stage = $this->buildDomainObject($result);

        return $stage;
    }

    public function buildDomainObject(array $result): Stage
    {
        $stage = new GroupStage(
            new Uuid($result['uuid']),
            new Uuid($result['tournament_uuid'])
        );

        $stage->setType($result['type']);
        $stage->setPlacesNumberInGroup((int) $result['places_number_in_group']);

        return $stage;
    }
}
