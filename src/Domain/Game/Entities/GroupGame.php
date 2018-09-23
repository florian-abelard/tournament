<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;
use Flo\Tournoi\Domain\Core\ValueObjects\NullDateTime;
use Flo\Tournoi\Domain\Game\ValueObjects\GameType;
use Flo\Tournoi\Domain\Game\ValueObjects\GameStatus;
use Flo\Tournoi\Domain\Game\Entities\Game;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Game\DataTransferObjects as DTO;

class GroupGame extends Game
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
            new GameType(GameType::TYPE_GROUP)
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

    public function toDto(): DTO\GroupGame
    {
        return new DTO\GroupGame(
            $this->uuid()->value(),
            $this->player1()->uuid()->value(),
            $this->player2()->uuid()->value(),
            $this->stageUuid()->value(),
            $this->groupUuid() ? $this->groupUuid()->value() : null,
            $this->position(),
            $this->status()->value(),
            $this->playingDate()->value(),
            $this->numberOfSetsToWin(),
            $this->winner() ? $this->winner()->uuid()->value() : null
        );
    }
}
