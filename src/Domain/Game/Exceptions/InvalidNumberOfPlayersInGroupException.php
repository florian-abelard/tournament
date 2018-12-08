<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Exceptions;

class InvalidNumberOfPlayersInGroupException extends \DomainException
{
    public function __construct($number)
    {
        parent::__construct(sprintf(
            'Invalid number of players in group : "%s"',
            $number
        ));
    }
}
