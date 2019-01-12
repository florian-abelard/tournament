<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Group\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\Collections\GroupMatchCollection;
use Flo\Tournoi\Domain\Match\Entities\Match;
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
        $matches;

    public function __construct(Uuid $uuid, Uuid $stageUuid)
    {
        $this->uuid = $uuid;
        $this->stageUuid = $stageUuid;

        $this->players = new PlayerCollection();
        $this->matches = new GroupMatchCollection();
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

    public function matches(): GroupMatchCollection
    {
        return $this->matches;
    }

    public function addMatch(Match $match): void
    {
        $this->matches->add($match);
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
