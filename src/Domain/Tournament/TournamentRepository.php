<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Tournament;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;

interface TournamentRepository
{
    public function persist(Tournament $tournament): void;

    public function findById(Uuid $uuid): ?Tournament;

    public function findAll(): iterable;

    public function remove(Uuid $uuid): void;
}
