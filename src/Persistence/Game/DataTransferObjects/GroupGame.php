<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Game\DataTransferObjects;

use DateTime;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\ValueObjects\GameStatus;
use Flo\Tournoi\Domain\Player\Entities\Player;

class GroupGame
{
    private
        $uuid,
        $player1,
        $player2,
        $stageUuid,
        $groupUuid,
        $position,
        $status,
        $playingDate,
        $numberOfSetsToWin,
        $winner;

    public function __construct(
        Uuid $uuid,
        Player $player1,
        Player $player2,
        Uuid $stageUuid,
        Uuid $groupUuid,
        ?int $position,
        GameStatus $status,
        DateTime $playingDate,
        ?int $numberOfSetsToWin,
        ?Player $winner
    ){
        $this->uuid = $uuid;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->stageUuid = $stageUuid;
        $this->groupUuid = $groupUuid;
        $this->position = $position;
        $this->status = $status;
        $this->playingDate = $playingDate;
        $this->numberOfSetsToWin = $numberOfSetsToWin;
        $this->winner = $winner;
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function player1Uuid(): string
    {
        return $this->player1->uuid()->value();
    }

    public function player2Uuid(): string
    {
        return $this->player2->uuid()->value();
    }

    public function stageUuid(): string
    {
        return $this->stageUuid->value();
    }

    public function groupUuid(): string
    {
        return $this->groupUuid->value();
    }

    public function position(): ?int
    {
        return $this->position;
    }

    public function status(): string
    {
        return $this->status->value();
    }

    public function playingDate(): ?string
    {
        return $this->playingDate->value();
    }

    public function numberOfSetsToWin(): ?int
    {
        return $this->numberOfSetsToWin;
    }

    public function winnerUuid(): ?string
    {
        if ($this->winner instanceof Player)
        {
            return $this->winner->uuid()->value();
        }
        return null;
    }
}
