<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Tournament;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Collections\TournamentCollection;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;

interface TournamentRepository
{
    public function persist(Tournament $tournament): void;

    public function findById(Uuid $uuid): ?Tournament;

    public function findAll(): TournamentCollection;

    public function remove(Uuid $uuid): void;

    private function buildDomainObject(array $result): Tournament;
}
