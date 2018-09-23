<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Game\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Collections\GroupGameCollection;
use Flo\Tournoi\Domain\Game\Entities\Game;
use Flo\Tournoi\Domain\Game\GameRepository;
use Flo\Tournoi\Domain\Game\Entities\GroupGame;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlCore;

class Mysql extends MysqlCore implements GameRepository
{
    private const
        TABLE = 'game',
        PLAYER_TABLE = 'player',
        STAGE_TABLE = 'stage',
        GROUP_TABLE = 'group';

    public function persist(Game $game): void
    {
        $table = self::TABLE;
        $dto = $game->toDTO();

        $sql = <<<SQL
            INSERT INTO $table (uuid, player1_uuid, player2_uuid, stage_uuid, group_uuid, position, status, playing_date, number_of_sets_to_win, winner_uuid)
            VALUES (:uuid, :player1Uuid, :player2Uuid, :stageUuid, :groupUuid, :position, :status, :playingDate, :numberOfSetsToWin, :winnerUuid)
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
        $statement->bindValue(':numberOfSetsToWin', $dto->numberOfSetsToWin());
        $statement->bindValue(':winnerUuid', $dto->winnerUuid());
        $statement->execute();
    }

    public function findByGroupId(Uuid $groupId): GroupGameCollection
    {
        $table = self::TABLE;
        $playerTable = self::PLAYER_TABLE;
        $groupTable = self::GROUP_TABLE;

        $sql = <<<SQL
            SELECT ga.*, pl1.name as player1_name, pl2.name as player2_name
            FROM `$table` as ga
            INNER JOIN `$playerTable` as pl1
            ON pl1.uuid = ga.player1_uuid
            INNER JOIN `$playerTable` as pl2
            ON pl2.uuid = ga.player2_uuid
            WHERE group_uuid = :groupUuid
SQL;

        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->bindValue(':groupUuid', $groupId->value());
        $statement->execute();

        $games = new GroupGameCollection();

        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result)
        {
            $games->add($this->buildDomainObject($result));
        }

        return $games;
    }

    private function buildDomainObject(array $result): Game
    {
        $game = new GroupGame(
            new Uuid($result['uuid']),
            $this->buildPlayerDomainObject($result, 1),
            $this->buildPlayerDomainObject($result, 2),
            new Uuid($result['stage_uuid']),
            new Uuid($result['group_uuid'])
        );
        $game->setPosition($result['position']);

        return $game;
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
