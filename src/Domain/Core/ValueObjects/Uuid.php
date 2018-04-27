<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Core\ValueObjects;

use Ramsey\Uuid\Uuid as RamseyUuid;

final class Uuid {

    private
        $uuid;

    public function __construct()
    {
        $this->uuid = (string) RamseyUuid::uuid4();
    }

    public function value(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
