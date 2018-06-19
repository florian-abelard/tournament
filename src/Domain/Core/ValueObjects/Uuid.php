<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Core\ValueObjects;

use Flo\Tournoi\Domain\Core\Exceptions\InvalidUuidException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Uuid as UuidConstraint;

final class Uuid
{
    private
        $uuid;

    public function __construct(?string $uuid = null)
    {
        if ($uuid === null)
        {
            $uuid = (string) RamseyUuid::uuid4();
        }
        else {
            $this->validate($uuid);
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

    public function equals(Uuid $uuid): bool
    {
        return $this->value() === $uuid->value();
    }

    public function fromString(string $uuid): Uuid
    {
        return (new Uuid())->generate();
    }

    public function validate(string $uuid): void
    {
        $validator = Validation::createValidator();

        $errors = $validator->validate($uuid, new UuidConstraint);

        if (count($errors) !== 0)
        {
            throw new InvalidUuidException($uuid);
        }
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
