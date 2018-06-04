<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Registration\Collections\RegistrationCollection;
use Flo\Tournoi\Persistence\Player\DataTransferObjects as DTO;
use Flo\Tournoi\Domain\Registration\Entities\Registration;

class Player
{
    private
        $uuid,
        $name,
        $points,
        $registrations;

    public function __construct(Uuid $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;

        $this->registrations = new RegistrationCollection;
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function points(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function registrations(): RegistrationCollection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): void
    {
        $this->registrations->add($registration);
    }

    public function toDTO(): DTO\Player
    {
        return new DTO\Player(
            $this->uuid->value(),
            $this->name
        );
    }
}
