<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;

interface PlayerRepository
{
    public function persist(Player $player): void;

    public function findById(Uuid $uuid): ?Player;

    public function findAll(): PlayerCollection;

    public function findByTournamentId(Uuid $tournamentUuid): PlayerCollection;

    public function findNotInTournament(Uuid $tournamentUuid): PlayerCollection;

    public function remove(Uuid $uuid): void;

    private function buildDomainObject(array $result): Player;
}
