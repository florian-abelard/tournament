<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Group\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Collections\GameCollection;
use Flo\Tournoi\Domain\Game\Entities\Game;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Group\DataTransferObjects as DTO;

class Group
{
    private
        $uuid,
        $stageUuid,
        $label,
        $placesNumber,
        $players,
        $games;

    public function __construct(Uuid $uuid, Uuid $stageUuid)
    {
        $this->uuid = $uuid;
        $this->stageUuid = $stageUuid;

        $this->players = new PlayerCollection();
        $this->games = new GameCollection();
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function placesNumber(): int
    {
        return $this->placesNumber;
    }

    public function setPlacesNumber(int $max): self
    {
        $this->placesNumber = $max;

        return $this;
    }

    public function stageUuid(): Uuid
    {
        return $this->stageUuid;
    }

    public function players(): PlayerCollection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): void
    {
        $this->players->add($player);
    }

    public function games(): GameCollection
    {
        return $this->games;
    }

    public function addGame(Game $game): void
    {
        $this->games->add($game);
    }

    public function toDTO(): DTO\Group
    {
        return new DTO\Group(
            $this->uuid->value(),
            $this->stageUuid->value(),
            $this->placesNumber,
            $this->label
        );
    }
}
