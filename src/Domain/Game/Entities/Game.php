<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Entities;

use Flo\Tournoi\Domain\Player\Entities\Player;

class Game
{
    private
        $player1,
        $player2,
        $status,
        $winner,
        $sets;

    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;

        // $this->sets = new SetCollection();
    }
}
