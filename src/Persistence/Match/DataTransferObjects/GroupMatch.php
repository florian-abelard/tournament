<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Match\DataTransferObjects;

use DateTime;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchResult;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchStatus;
use Flo\Tournoi\Domain\Player\Entities\Player;

class GroupMatch
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
        $result;

    public function __construct(
        Uuid $uuid,
        Player $player1,
        Player $player2,
        Uuid $stageUuid,
        Uuid $groupUuid,
        ?int $position,
        MatchStatus $status,
        DateTime $playingDate,
        ?MatchResult $result
    ){
        $this->uuid = $uuid;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->stageUuid = $stageUuid;
        $this->groupUuid = $groupUuid;
        $this->position = $position;
        $this->status = $status;
        $this->playingDate = $playingDate;
        $this->result = $result;
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

    public function result(): ?string
    {
        return serialize($this->result);
    }

    public function winnerUuid(): ?string
    {
        if (is_null($this->result)) 
        {
            return null;
        }
        if ($this->result->winner() instanceof Player)
        {
            return $this->result->winner()->uuid()->value();
        }

        return null;
    }
}
