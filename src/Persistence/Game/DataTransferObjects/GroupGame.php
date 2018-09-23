<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Game\DataTransferObjects;

use DateTime;

class GroupGame
{
    private
        $uuid,
        $player1Uuid,
        $player2Uuid,
        $stageUuid,
        $groupUuid,
        $position,
        $status,
        $playingDate,
        $numberOfSetsToWin,
        $winnerUuid;

    public function __construct(
        string $uuid,
        string $player1Uuid,
        string $player2Uuid,
        string $stageUuid,
        string $groupUuid,
        ?int $position,
        string $status,
        ?string $playingDate,
        ?string $numberOfSetsToWin,
        ?string $winnerUuid
    ){
        $this->uuid = $uuid;
        $this->player1Uuid = $player1Uuid;
        $this->player2Uuid = $player2Uuid;
        $this->stageUuid = $stageUuid;
        $this->groupUuid = $groupUuid;
        $this->position = $position;
        $this->status = $status;
        $this->playingDate = $playingDate;
        $this->numberOfSetsToWin = $numberOfSetsToWin;
        $this->winnerUuid = $winnerUuid;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function player1Uuid(): string
    {
        return $this->player1Uuid;
    }

    public function player2Uuid(): string
    {
        return $this->player2Uuid;
    }

    public function stageUuid(): string
    {
        return $this->stageUuid;
    }

    public function groupUuid(): string
    {
        return $this->groupUuid;
    }

    public function position(): ?int
    {
        return $this->position;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function playingDate(): ?string
    {
        return $this->playingDate;
    }

    public function numberOfSetsToWin(): ?int
    {
        return $this->numberOfSetsToWin;
    }

    public function winnerUuid(): ?string
    {
        return $this->winnerUuid;
    }
}
