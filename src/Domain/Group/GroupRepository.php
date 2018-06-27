<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Group;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Group\Entities\Group;

interface GroupRepository
{
    public function persist(Group $group): void;

    public function findByStageId(Uuid $stageUuid): GroupCollection;
}
