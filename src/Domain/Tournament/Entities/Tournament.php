<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Tournament\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Registration\Entities\Registration;
use Flo\Tournoi\Persistence\Tournament\DataTransferObjects as DTO;

class Tournament
{
    private
        $uuid,
        $name;

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

    public function toDTO(): DTO\Tournament
    {
        return new DTO\Tournament(
            $this->uuid->value(),
            $this->name
        );
    }
}
