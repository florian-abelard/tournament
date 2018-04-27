<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player;

use Flo\Tournoi\Domain\Player\Entities\Player;

interface PlayerRepository
{
    public function persist(Player $player): void;

    public function findById(string $id): ?Player;

    public function findAll(): iterable;
}
