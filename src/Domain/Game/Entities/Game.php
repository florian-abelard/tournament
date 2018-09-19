<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;
use Flo\Tournoi\Domain\Core\ValueObjects\NullDateTime;
use Flo\Tournoi\Domain\Game\ValueObjects\GameType;
use Flo\Tournoi\Domain\Game\ValueObjects\GameStatus;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Game\DataTransferObjects as DTO;

class Game
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

    public function __construct(Uuid $uuid, Player $player1, Player $player2, Uuid $stageUuid, GameType $type)
    {
        $this->uuid = $uuid;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->stageUuid = $stageUuid;
        $this->type = $type;

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

    public function status(): GameStatus
    {
        return $this->status;
    }

    public function setStatus(GameStatus $status): self
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
        $this->date = $playingDate;

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
