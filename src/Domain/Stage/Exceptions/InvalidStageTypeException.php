<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Exceptions;

class InvalidStageTypeException extends \DomainException
{
    public function __construct($type)
    {
        parent::__construct(sprintf(
            'Invalid stage type : "%s"',
            $type
        ));
    }
}
