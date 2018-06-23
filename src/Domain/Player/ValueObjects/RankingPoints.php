<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player\ValueObjects;

use Flo\Tournoi\Domain\Player\Exceptions\InvalidRankingPointsException;

final class RankingPoints
{
    private
        $rankingPoints;

    public function __construct(?int $rankingPoints = null)
    {
        if ($rankingPoints !== null)
        {
            $this->validate($rankingPoints);
        }

        $this->rankingPoints = $rankingPoints;
    }

    public function value(): ?int
    {
        return $this->rankingPoints;
    }

    public function equals(RankingPoints $rankingPoints): bool
    {
        return $this->value() === $rankingPoints->value();
    }

    public function validate(int $rankingPoints): void
    {
        if ($rankingPoints < 1 || $rankingPoints > 5000 )
        {
            throw new InvalidRankingPointsException($rankingPoints);
        }
    }

    public function fromString(?string $points): ?RankingPoints
    {
        if ($points)
        {
            $points = (int) $points;
        }

        return new RankingPoints($points);
    }
}
