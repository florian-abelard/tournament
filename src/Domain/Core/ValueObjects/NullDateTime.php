<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Core\ValueObjects;

use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;
// use Symfony\Component\Validator\Validation;
// use Symfony\Component\Validator\Constraints\DateTime as DateTimeConstraint;

class NullDateTime extends DateTime
{
    public function value(): ?string
    {
        return null;
    }
}
