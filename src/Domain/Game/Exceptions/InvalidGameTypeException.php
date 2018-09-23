<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Exceptions;

class InvalidGameTypeException extends \DomainException
{
    public function __construct($status)
    {
        parent::__construct(sprintf(
            'Invalid game type : "%s"',
            $status
        ));
    }
}
