<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\ValueObjects;

use Flo\Tournoi\Domain\Match\Exceptions\InvalidSetException;

final class Set implements \JsonSerializable
{
    private
        $scorePlayer1,
        $scorePlayer2,
        $numberOfWinningPoints;

    public function __construct(int $scorePlayer1, int $scorePlayer2)
    {
        $this->validate($score1, $score2);
        
        $this->score1 = $score1;
        $this->score2 = $score2;

        $this->numberOfWinningPoints = 11; // Todo tournament configuration

    }

    public function score1(): ?int
    {
        return $this->score1;
    }

    public function score2(): ?int
    {
        return $this->score2;
    }

    private function validate(int $score1, int $score2)
    {
        if ($score1 < $this->numberOfWinningPoints && $score2 < $this->numberOfWinningPoints)
        {
            throw new InvalidSetException($score1, $score2);
        }
        if (!$this->hasAtLeastTwoPointsOfDifference($score1, $score2)) 
        {
            throw new InvalidSetException($score1, $score2);
        }

        return true;
    }

    private function hasAtLeastTwoPointsOfDifference(int $score1, int $score2)
    {
        if (abs($score1 - $score2) >= 2)
        {
            return true;
        }

        return false;
    }

    public function jsonSerialize()
    {
        return
            [
                'score1'   => $this->score1(),
                'score2' => $this->score2()
            ];
    }
}
