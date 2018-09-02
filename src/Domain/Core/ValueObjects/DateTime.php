<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Core\ValueObjects;

// use Symfony\Component\Validator\Validation;
// use Symfony\Component\Validator\Constraints\DateTime as DateTimeConstraint;

class DateTime extends \DateTime
{
    public function value(): ?string
    {
        return $this->format('Y-m-d H:i:s');
    }

    public function equals(DateTime $datetime): bool
    {
        return $this->value() === $datetime->value();
    }
}
