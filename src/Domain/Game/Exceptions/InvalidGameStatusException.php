<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Exceptions;

class InvalidGameStatusException extends \DomainException
{
    public function __construct($status)
    {
        parent::__construct(sprintf(
            'Invalid game status : "%s"',
            $status
        ));
    }
}
