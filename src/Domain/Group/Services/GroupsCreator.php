<?php

declare(strict_types= 1);

namespace Flo\Tournoi\Domain\Group\Services;

use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Stage\Entities\GroupStage;

class GroupsCreator
{
    public function create(GroupStage $groupStage, PlayerCollection $playerCollection): GroupCollection
    {
        $groups = new GroupCollection();

        $placesNumberInGroup = $groupStage->placesNumberInGroup();

        $playersNumber = $playerCollection->count();

        $playerCollection->sortByRankingPoints();

        return $groups;
    }
}
