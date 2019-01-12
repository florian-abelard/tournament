<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;
use Flo\Tournoi\Domain\Core\ValueObjects\NullDateTime;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchType;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchStatus;
use Flo\Tournoi\Domain\Match\Entities\Match;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Match\DataTransferObjects as DTO;

class GroupMatch extends Match
{
    private
        $groupUuid,
        $position;

    public function __construct(Uuid $uuid, Player $player1, Player $player2, Uuid $stageUuid, Uuid $groupUuid)
    {
        parent::__construct(
            $uuid,
            $player1,
            $player2,
            $stageUuid,
            new MatchType(MatchType::TYPE_GROUP)
        );

        $this->groupUuid = $groupUuid;
    }

    public function groupUuid(): Uuid
    {
        return $this->groupUuid;
    }

    public function position(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function toDto(): DTO\GroupMatch
    {
        return new DTO\GroupMatch(
            $this->uuid(),
            $this->player1(),
            $this->player2(),
            $this->stageUuid(),
            $this->groupUuid(),
            $this->position(),
            $this->status(),
            $this->playingDate(),
            $this->numberOfSetsToWin(),
            $this->winner()
        );
    }
}
