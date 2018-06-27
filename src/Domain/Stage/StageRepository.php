<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Stage\Entities\Stage;

interface StageRepository
{
    public function persist(Stage $stage): void;

    public function findById(Uuid $uuid): ?Stage;
}
