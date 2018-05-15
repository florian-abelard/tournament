<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Tournament\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;

class Tournament
{
    private
        $uuid,
        $name,
        $players;

    public function __construct(Uuid $uuid, string $name, iterable $players = [])
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->players = new PlayerCollection($players);
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function addPlayer(Player $player): void
    {
        $player->addTournament($this);

        $this->players->add($player);
    }

    // public function toDTO(): DTO\Tournament
    // {
    //     return new DTO\Tournament(
    //         $this->uuid->value(),
    //         $this->name
    //     );
    // }
}
