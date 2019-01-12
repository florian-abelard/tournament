<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;
use Flo\Tournoi\Domain\Core\ValueObjects\NullDateTime;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchType;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchStatus;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Match\DataTransferObjects as DTO;

class Match
{
    private
        $uuid,
        $player1,
        $player2,
        $stageUuid,
        $type,
        $status,
        $playingDate,
        $numberOfSetsToWin,
        $winner,
        $sets;

    public function __construct(Uuid $uuid, Player $player1, Player $player2, Uuid $stageUuid, MatchType $type)
    {
        $this->uuid = $uuid;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->stageUuid = $stageUuid;
        $this->type = $type;

        $this->status = new MatchStatus('upcoming');
        $this->playingDate = new NullDateTime();

        // $this->sets = new SetCollection();
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function player1(): Player
    {
        return $this->player1;
    }

    public function player2(): Player
    {
        return $this->player2;
    }

    public function stageUuid(): Uuid
    {
        return $this->stageUuid;
    }

    public function type(): MatchType
    {
        return $this->type;
    }

    public function status(): MatchStatus
    {
        return $this->status;
    }

    public function setStatus(MatchStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function playingDate(): DateTime
    {
        return $this->playingDate;
    }

    public function setPlayingDate(DateTime $playingDate): self
    {
        $this->playingDate = $playingDate;

        return $this;
    }

    public function numberOfSetsToWin(): ?int
    {
        return $this->numberOfSetsToWin;
    }

    public function setNumberOfSetsToWin(int $numberOfSetsToWin): self
    {
        $this->numberOfSetsToWin = $numberOfSetsToWin;

        return $this;
    }

    public function winner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(Player $winner): self
    {
        $this->winner = $winner;

        return $this;
    }
}
