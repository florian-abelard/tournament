<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player\Exceptions;

class InvalidRankingPointsException extends \DomainException
{
    public function __construct($points)
    {
        parent::__construct(sprintf(
            'Invalid ranking points : "%s"',
            $points
        ));
    }
}
