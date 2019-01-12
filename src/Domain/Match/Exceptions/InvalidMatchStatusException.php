<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\Exceptions;

class InvalidMatchStatusException extends \DomainException
{
    public function __construct($status)
    {
        parent::__construct(sprintf(
            'Invalid match status : "%s"',
            $status
        ));
    }
}
