<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\ValueObjects;

use Flo\Tournoi\Domain\Player\Entities\Player;

final class Set
{
    private
        $scorePlayer1,
        $scorePlayer2,
        $numberOfWinningPoints;

    public function __construct(int $scorePlayer1, int $scorePlayer2)
    {
        $this->scorePlayer1 = $scorePlayer1;
        $this->scorePlayer2 = $scorePlayer2;

        $this->numberOfWinningPoints = 11; // Todo tournament configuration
    }

    public function scorePlayer1(): ?int
    {
        return $this->scorePlayer1;
    }

    public function scorePlayer2(): ?int
    {
        return $this->scorePlayer2;
    }

    public function validate()
    {
        if ($this->scorePlayer1 < $this->numberOfWinningPoints && $this->scorePlayer2 < $this->numberOfWinningPoints)
        {
            return false;
        }
        if (!$this->hasAtLeastTwoPoints())
        {
            return false;
        }

        return true;
    }

    public function hasAtLeastTwoPoints()
    {
        if (abs($this->scorePlayer1 - $this->scorePlayer2) >= 2)
        {
            return true;
        }

        return false;
    }
}
