<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\ValueObjects;

use Flo\Tournoi\Domain\Player\Entities\Player;

final class MatchResult
{
    private
        $player1,
        $player2,
        $numberOfWinningSets,
        $sets;

    public function __construct(Player $player1, Player $player2, SetCollection $sets)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;

        $this->numberOfWinningSets = 3;
        $this->sets = $sets;
    }

    public function winner(): ?Player
    {
        $numberOfSetsWonByPlayer1 = 0;
        $numberOfSetsWonByPlayer2 = 0;

        foreach ($this->sets as $set)
        {
            if ($set->scorePlayer1() > $set->scorePlayer2())
            {
                $numberOfSetsWonByPlayer1++;
            }
            else {
                $numberOfSetsWonByPlayer2++;
            }
        }

        if ($numberOfSetsWonByPlayer1 >= $this->numberOfWinningSets)
        {
            return $this->player1;
        }
        if ($numberOfSetsWonByPlayer2 >= $this->numberOfWinningSets)
        {
            return $this->player2;
        }

        return null;
    }

    public function maximumNumberOfSets(): int
    {
        return $this->numberOfWinningSets * 2 - 1;
    }

    public function sets(): SetCollection
    {
        return $this->sets;
    }
}
