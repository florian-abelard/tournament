<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Tournament\Exceptions;

class InvalidTournamentStatusException extends \DomainException
{
    public function __construct($status)
    {
        parent::__construct(sprintf(
            'Invalid tournament status : "%s"',
            $status
        ));
    }
}
