<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Core\ValueObjects;

use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;

class NullDateTime extends DateTime
{
    public function value(): ?string
    {
        return null;
    }
}
