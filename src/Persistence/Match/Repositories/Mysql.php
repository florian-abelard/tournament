<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Match\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\Collections\GroupMatchCollection;
use Flo\Tournoi\Domain\Match\Entities\Match;
use Flo\Tournoi\Domain\Match\MatchRepository;
use Flo\Tournoi\Domain\Match\Entities\GroupMatch;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlCore;

class Mysql extends MysqlCore implements MatchRepository
{
    private const
        TABLE = 'match',
        PLAYER_TABLE = 'player',
        GROUP_TABLE = 'group';

    public function persist(Match $match): void
    {
        $table = self::TABLE;
        $dto = $match->toDTO();

        $sql = <<<SQL
            INSERT INTO `$table` (uuid, player1_uuid, player2_uuid, stage_uuid, group_uuid, position, status, playing_date, result, winner_uuid)
            VALUES (:uuid, :player1Uuid, :player2Uuid, :stageUuid, :groupUuid, :position, :status, :playingDate, :result, :winnerUuid)
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $dto->uuid());
        $statement->bindValue(':player1Uuid', $dto->player1Uuid());
        $statement->bindValue(':player2Uuid', $dto->player2Uuid());
        $statement->bindValue(':stageUuid', $dto->stageUuid());
        $statement->bindValue(':groupUuid', $dto->groupUuid());
        $statement->bindValue(':position', $dto->position());
        $statement->bindValue(':status', $dto->status());
        $statement->bindValue(':playingDate', $dto->playingDate());
        $statement->bindValue(':result', $dto->result());
        $statement->bindValue(':winnerUuid', $dto->winnerUuid());
        $statement->execute();
    }

    public function update(Match $match): void
    {
        $table = self::TABLE;
        $dto = $match->toDTO();

        $sql = <<<SQL
            UPDATE `$table` 
            SET 
                player1_uuid = :player1Uuid,
                player2_uuid = :player2Uuid,
                stage_uuid = :stageUuid,
                group_uuid = :groupUuid,
                position = :position,
                status = :status,
                playing_date = :playingDate,
                result = :result
            WHERE uuid = :uuid
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $dto->uuid());
        $statement->bindValue(':player1Uuid', $dto->player1Uuid());
        $statement->bindValue(':player2Uuid', $dto->player2Uuid());
        $statement->bindValue(':stageUuid', $dto->stageUuid());
        $statement->bindValue(':groupUuid', $dto->groupUuid());
        $statement->bindValue(':position', $dto->position());
        $statement->bindValue(':status', $dto->status());
        $statement->bindValue(':playingDate', $dto->playingDate());
        $statement->bindValue(':result', $dto->result());
        $statement->execute();
    }

    public function findById(Uuid $id): Match
    {
        $table = self::TABLE;
        $playerTable = self::PLAYER_TABLE;

        $sql = <<<SQL
            SELECT ma.*, pl1.name as player1_name, pl2.name as player2_name
            FROM `$table` as ma
            INNER JOIN `$playerTable` as pl1
            ON pl1.uuid = ma.player1_uuid
            INNER JOIN `$playerTable` as pl2
            ON pl2.uuid = ma.player2_uuid
            WHERE ma.uuid = :uuid
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':uuid', $id->value());
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return null;
        }

        $result = $statement->fetch();
        $match = $this->buildDomainObject($result);

        return $match;

    }

    public function findByGroupId(Uuid $groupId): GroupMatchCollection
    {
        $table = self::TABLE;
        $playerTable = self::PLAYER_TABLE;

        $sql = <<<SQL
            SELECT ma.*, pl1.name as player1_name, pl2.name as player2_name
            FROM `$table` as ma
            INNER JOIN `$playerTable` as pl1
            ON pl1.uuid = ma.player1_uuid
            INNER JOIN `$playerTable` as pl2
            ON pl2.uuid = ma.player2_uuid
            WHERE group_uuid = :groupUuid
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':groupUuid', $groupId->value());
        $statement->execute();

        $matches = new GroupMatchCollection();

        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result)
        {
            $matches->add($this->buildDomainObject($result));
        }

        return $matches;
    }

    private function buildDomainObject(array $result): Match
    {
        $match = new GroupMatch(
            new Uuid($result['uuid']),
            $this->buildPlayerDomainObject($result, 1),
            $this->buildPlayerDomainObject($result, 2),
            new Uuid($result['stage_uuid']),
            new Uuid($result['group_uuid'])
        );
        $match->setPosition($result['position']);
        $match->setResult(unserialize($result['result']));

        return $match;
    }

    private function buildPlayerDomainObject(array $result, int $playerNumero): Player
    {
        $player = new Player(
            new Uuid($result['player' . $playerNumero . '_uuid']),
            $result['player' . $playerNumero . '_name']
        );

        return $player;
    }
}
