<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Group\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Collections\GroupGameCollection;
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
        $numberOfPlaces,
        $players,
        $games;

    public function __construct(Uuid $uuid, Uuid $stageUuid)
    {
        $this->uuid = $uuid;
        $this->stageUuid = $stageUuid;

        $this->players = new PlayerCollection();
        $this->games = new GroupGameCollection();
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

    public function numberOfPlaces(): int
    {
        return $this->numberOfPlaces;
    }

    public function setNumberOfPlaces(int $max): self
    {
        $this->numberOfPlaces = $max;

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

    public function games(): GroupGameCollection
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
            $this->numberOfPlaces,
            $this->label
        );
    }
}
