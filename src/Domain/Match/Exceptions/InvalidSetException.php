<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\Exceptions;

class InvalidSetException extends \DomainException
{
    public function __construct(int $score1, int $score2)
    {
        parent::__construct(sprintf(
            'Invalid set result : "%d - %d"',
            $score1,
            $score2
        ));
    }
}
