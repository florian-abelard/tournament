<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Tournament\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\TournamentPlayer\Collections\TournamentPlayerCollection as ParticipatingPlayerCollection;
use Flo\Tournoi\Domain\TournamentPlayer\Entities\TournamentPlayer;

class Tournament
{
    private
        $uuid,
        $name,
        $participatingPlayers;

    public function __construct(Uuid $uuid, string $name, iterable $players = [])
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->participatingPlayers = new ParticipatingPlayerCollection($players);
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function addPlayer(TournamentPlayer $player): void
    {
        $player->addTournament($this);

        $this->participatingPlayers->add($player);
    }

    // public function toDTO(): DTO\Tournament
    // {
    //     return new DTO\Tournament(
    //         $this->uuid->value(),
    //         $this->name
    //     );
    // }
}
