<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Core\ValueObjects;

use Ramsey\Uuid\Uuid as RamseyUuid;

final class Uuid {

    private
        $uuid;

    public function __construct(?string $uuid = null)
    {
        if ($uuid === null)
        {
            $uuid = (string) RamseyUuid::uuid4();
        }

        $this->uuid = $uuid;
    }

    public function generate(): Uuid
    {
        $this->uuid = (string) RamseyUuid::uuid4();

        return $this;
    }

    public function value(): string
    {
        return $this->uuid;
    }

    public function fromString(string $uuid): Uuid
    {
        return (new Uuid())->generate();
    }

    public function validate(Uuid $uuid): void
    {
        // TODO
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
