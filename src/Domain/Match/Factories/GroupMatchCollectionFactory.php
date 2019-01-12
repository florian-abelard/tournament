<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\Factories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\Collections\GroupMatchCollection;
use Flo\Tournoi\Domain\Match\Entities\GroupMatch;
use Flo\Tournoi\Domain\Match\Exceptions\InvalidNumberOfPlayersInGroupException;
use Flo\Tournoi\Domain\Group\Entities\Group;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;

class GroupMatchCollectionFactory
{
    public function __construct()
    {
    }

    public function create(Group $group): GroupMatchCollection
    {
        $matches = new GroupMatchCollection();

        $playersInGroup = $group->players();

        $matchesOrdered = $this->retrieveMatchesPositionInGroup($playersInGroup);

        foreach ($matchesOrdered as $matchPosition => $matchPlayers)
        {
            $match = new GroupMatch(
                new Uuid(),
                $playersInGroup[$matchPlayers[0]-1],
                $playersInGroup[$matchPlayers[1]-1],
                $group->stageUuid(),
                $group->uuid()
            );
            $match->setPosition($matchPosition);
            $matches->add($match);
        }

        return $matches;
    }

    private function retrieveMatchesPositionInGroup(PlayerCollection $players): array
    {
        $numberOfPlayers = count($players);

        switch ($numberOfPlayers)
        {
            case 2:
                return [
                    1 => [1, 2]
                ];

            case 3:
                return [
                    1 => [1, 3],
                    2 => [2, 3],
                    3 => [1, 2]
                ];

            case 4:
                return [
                    1 => [1, 4],
                    2 => [2, 3],
                    3 => [1, 3],
                    4 => [4, 2],
                    5 => [1, 2],
                    6 => [3, 4]
                ];

            default:
                throw new InvalidNumberOfPlayersInGroupException($numberOfPlayers);
        }
    }
}
