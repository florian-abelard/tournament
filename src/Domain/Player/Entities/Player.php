<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Persistence\Player\DataTransferObjects as DTO;
use Flo\Tournoi\Domain\Registration\Entities\Registration;

class Player
{
    private
        $uuid,
        $name,
        $points;

    public function __construct(Uuid $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
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

    public function toDTO(): DTO\Player
    {
        return new DTO\Player(
            $this->uuid->value(),
            $this->name
        );
    }
}
