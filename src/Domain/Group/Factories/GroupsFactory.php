<?php

declare(strict_types= 1);

namespace Flo\Tournoi\Domain\Group\Factories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Group\Entities\Group;
use Flo\Tournoi\Domain\Group\Services\RequiredNumberOfGroupsCalculator;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Stage\Entities\GroupStage;

class GroupsFactory
{
    private
        $requiredNumberOfGroupsCalculator,
        $groups;

    public function __construct(RequiredNumberOfGroupsCalculator $requiredNumberOfGroupsCalculator)
    {
        $this->requiredNumberOfGroupsCalculator = $requiredNumberOfGroupsCalculator;
    }

    public function create(PlayerCollection $players, GroupStage $groupStage): GroupCollection
    {
        $this->groups = new GroupCollection();

        $numberOfPlacesInGroup = $groupStage->numberOfPlacesInGroup();

        $numberOfPlayers = $players->count();

        $players->sortByRankingPoints();

        $numberOfGroups = $this->requiredNumberOfGroupsCalculator->calculate($numberOfPlayers, $numberOfPlacesInGroup);

        $this->initializeGroups($numberOfGroups, $numberOfPlacesInGroup, $groupStage->uuid());
        $this->fillsGroupsWithPlayers($players);

        return $this->groups;
    }

    private function initializeGroups(int $numberOfGroups, int $numberOfPlacesInGroup, Uuid $stageUuid): void
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($i = 0 ; $i < $numberOfGroups; ++$i)
        {
            $group = new Group(new Uuid(), $stageUuid);
            $group->setLabel($alphabet[$i]);
            $group->setNumberOfPlaces($numberOfPlacesInGroup);

            $this->groups->add($group);
        }
    }

    private function fillsGroupsWithPlayers(PlayerCollection $players): void
    {
        while ($players->count() > 0)
        {
            foreach ($this->groups as $group)
            {
                $player = $players->shift();

                $group->addPlayer($player);

                if ($players->count() === 0)
                {
                    break;
                }
            }
        }
    }
}
