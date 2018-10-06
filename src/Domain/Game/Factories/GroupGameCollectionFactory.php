<?php

declare(strict_types= 1);

namespace Flo\Tournoi\Domain\Game\Factories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Collections\GroupGameCollection;
use Flo\Tournoi\Domain\Game\Entities\GroupGame;
use Flo\Tournoi\Domain\Game\ValueObjects\GameStatus;
use Flo\Tournoi\Domain\Group\Entities\Group;

class GroupGameCollectionFactory
{
    public function __construct()
    {
    }

    public function create(Group $group): GroupGameCollection
    {
        $games = new GroupGameCollection();

        $playersInGroup = $group->players();

        $gamesOrdered = $this->retrieveGamesPositionInGroup($playersInGroup);

        foreach ($gamesOrdered as $gamePosition => $gamePlayers)
        {
            $game = new GroupGame(
                new Uuid(),
                $playersInGroup[$gamePlayers[0]-1],
                $playersInGroup[$gamePlayers[1]-1],
                $group->stageUuid(),
                $group->uuid()
            );
            $game->setPosition($gamePosition);
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
