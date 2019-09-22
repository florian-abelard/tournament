<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\Collections\GroupMatchCollection;
use Flo\Tournoi\Domain\Match\Entities\Match;

interface MatchRepository
{
    public function persist(Match $match): void;

    public function update(Match $match): void;

    public function findById(Uuid $uuid): ?Match;

    public function findByGroupId(Uuid $groupUuid): GroupMatchCollection;
}
