<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\Exceptions;

class InvalidMatchTypeException extends \DomainException
{
    public function __construct($status)
    {
        parent::__construct(sprintf(
            'Invalid match type : "%s"',
            $status
        ));
    }
}
