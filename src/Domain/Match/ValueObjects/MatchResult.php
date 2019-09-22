<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\ValueObjects;

use Flo\Tournoi\Domain\Match\Exceptions\InvalidMatchResultException;

final class MatchResult
{
    private
        $sets,
        $numberOfWinningSets;

    public function __construct(SetCollection $sets)
    {
        $this->numberOfWinningSets = 3;

        $this->validate($sets);

        $this->sets = $sets;
        
    }

    private function validate(SetCollection $sets)
    {
        $numberOfSetsWonByPlayer1 = 0;
        $numberOfSetsWonByPlayer2 = 0;
        
        foreach ($sets as $set) 
        {
            if ($set->score1() > $set->score2()) {
                $numberOfSetsWonByPlayer1++;
            } else {
                $numberOfSetsWonByPlayer2++;
            }
        }

        if (
            $numberOfSetsWonByPlayer1 < $this->numberOfWinningSets &&
            $numberOfSetsWonByPlayer2 < $this->numberOfWinningSets 
        ) {
            throw new InvalidMatchResultException($sets);
        }
    }

    public function sets(): SetCollection
    {
        return $this->sets;
    }

    public function sets(): SetCollection
    {
        return $this->sets;
    }
}
