<?php

declare(strict_types= 1);

namespace Flo\Tournoi\Domain\Game\Factories;

use Flo\Tournoi\Domain\Game\Collections\GameCollection;
use Flo\Tournoi\Domain\Game\Entities\Game;
use Flo\Tournoi\Domain\Group\Entities\Group;

class GameCollectionFactory
{
    public function __construct()
    {
    }

    public function create(Group $group): GameCollection
    {
        $games = new GameCollection();

        $playersInGroup = $group->players();

        $gamesOrdered = $this->retrieveGamesPositionInGroup($playersInGroup);

        foreach ($gamesOrdered as $gamePosition)
        {
            $game = new Game(
                $playersInGroup[$gamePosition[0]-1],
                $playersInGroup[$gamePosition[1]-1]
            );
            $games->add($game);
        }

        return $games;
    }

    private function retrieveGamesPositionInGroup($players): array
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
                throw new \Exception("Invalid number of players in group : " . $numberOfPlayers);
                break;
        }
    }
}
