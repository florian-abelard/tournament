<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\Exceptions;

use Flo\Tournoi\Domain\Match\ValueObjects\SetCollection;

class InvalidMatchResultException extends \DomainException
{
    public function __construct(SetCollection $sets)
    {
        parent::__construct(sprintf(
            'Invalid match result : %s',
            json_encode( (array)$sets )
        ));
    }
}
