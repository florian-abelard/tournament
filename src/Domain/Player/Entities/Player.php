<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Collections\TournamentCollection;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;
use Flo\Tournoi\Persistence\Player\DataTransferObjects as DTO;

class Player
{
    private
        $uuid,
        $name,
        $tournaments;

    public function __construct(Uuid $uuid, string $name, iterable $tournaments = [])
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->tournaments = new TournamentCollection($tournaments);
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function addTournament(Tournament $tournament): void
    {
        $this->tournaments->add($tournament);
    }

    public function toDTO(): DTO\Player
    {
        return new DTO\Player(
            $this->uuid->value(),
            $this->name
        );
    }
}
