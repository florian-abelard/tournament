<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\ValueObjects;

use Flo\Tournoi\Domain\Player\Entities\Player;

final class Set
{
    private
        $score1,
        $score2,
        $numberOfWinningPoints;

    public function __construct(int $score1, int $score2)
    {
        $this->score1 = $score1;
        $this->score2 = $score2;

        $this->numberOfWinningPoints = 11;
    }

    public function winner(): ?Player
    {
        return $this->winner;
    }
}
