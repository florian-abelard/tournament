<?php

declare(strict_types= 1);

namespace Flo\Tournoi\Domain\Group\Factories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Group\Entities\Group;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Stage\Entities\GroupStage;

class GroupsFactory
{
    private
        $groups;

    public function __construct()
    {
    }

    public function create(PlayerCollection $players, GroupStage $groupStage): GroupCollection
    {
        $this->groups = new GroupCollection();

        $placesNumberInGroup = $groupStage->placesNumberInGroup();

        $playersNumber = $players->count();

        $players->sortByRankingPoints();

        $groupsNumber = $this->calculateRequiredGroupsNumber($playersNumber, $placesNumberInGroup);

        $this->initializeGroups($groupsNumber, $placesNumberInGroup, $groupStage->uuid());
        $this->fillsGroupsWithPlayers($players);

        return $this->groups;
    }

    private function calculateRequiredGroupsNumber(int $playersNumber, int $placesNumberInGroup): ?int
    {
        try
        {
            $result = $playersNumber / $placesNumberInGroup;
            $result = ceil($result);
            $result = (int) $result;
        }
        catch (\Exception $e)
        {
            throw new \RuntimeException('Unable to calculate required groups number : ' . $e->getMessage());
        }

        return $result;
    }

    private function initializeGroups(int $groupsNumber, int $placesNumberInGroup, Uuid $stageUuid): void
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($i = 0 ; $i < $groupsNumber; ++$i)
        {
            $group = new Group(new Uuid(), $stageUuid);
            $group->setLabel($alphabet[$i]);
            $group->setPlacesNumber($placesNumberInGroup);

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
