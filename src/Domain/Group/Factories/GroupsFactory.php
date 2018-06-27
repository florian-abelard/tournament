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
        $groupStage,
        $players,
        $groups;

    public function __construct(GroupStage $groupStage, PlayerCollection $players)
    {
        $this->groupStage = $groupStage;
        $this->players = $players;

        $this->groups = new GroupCollection();
    }

    public function create(): GroupCollection
    {
        $placesNumberInGroup = $this->groupStage->placesNumberInGroup();

        $playersNumber = $this->players->count();

        $this->players->sortByRankingPoints();

        $groupsNumber = $this->calculateRequiredGroupsNumber($playersNumber, $placesNumberInGroup);

        $this->initializeGroups($groupsNumber, $placesNumberInGroup);
        $this->fillsGroupsWithPlayers($groupsNumber);

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

    private function initializeGroups(int $groupsNumber, int $placesNumberInGroup): void
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($i = 0 ; $i < $groupsNumber; ++$i)
        {
            $group = new Group(new Uuid(), $this->groupStage->uuid());
            $group->setLabel($alphabet[$i]);
            $group->setPlacesNumber($placesNumberInGroup);

            $this->groups->add($group);
        }
    }

    private function fillsGroupsWithPlayers(): void
    {
        while ($this->players->count() > 0)
        {
            foreach ($this->groups as $group)
            {
                $player = $this->players->shift();

                $group->addPlayer($player);

                if ($this->players->count() === 0)
                {
                    break;
                }
            }
        }
    }
}
