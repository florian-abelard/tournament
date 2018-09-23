<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Collections\GroupGameCollection;
use Flo\Tournoi\Domain\Game\Entities\Game;

interface GameRepository
{
    public function persist(Game $game): void;

    public function findByGroupId(Uuid $groupUuid): GroupGameCollection;
}
