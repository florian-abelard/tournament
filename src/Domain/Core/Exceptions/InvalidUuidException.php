<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Core\Exceptions;

class InvalidUuidException extends \DomainException
{
    public function __construct($uuid)
    {
        parent::__construct(sprintf(
            'Invalid uuid : "%s"',
            $uuid
        ));
    }
}
