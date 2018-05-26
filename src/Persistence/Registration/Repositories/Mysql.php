<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Registration\Repositories;

use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlAbstract;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Registration\Entities\Registration;
use Flo\Tournoi\Domain\Registration\RegistrationRepository;

class Mysql extends MysqlAbstract implements RegistrationRepository
{
    private const
        TABLE = 'registration';

    public function persist(Registration $registration): void
    {
        $table = self::TABLE;
        $dto = $registration->toDTO();

        $sql = <<<SQL
            INSERT INTO $table (player_uuid, tournament_uuid, registration_date)
            VALUES (:playerUuid, :tournamentUuid, :registrationDate)
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':playerUuid', $dto->playerUuid());
        $statement->bindValue(':tournamentUuid', $dto->tournamentUuid());
        $statement->bindValue(':registrationDate', $dto->registrationDate());
        $statement->execute();
    }
}
