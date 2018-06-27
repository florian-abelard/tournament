<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Player\DataTransferObjects;

class Player
{
    private
        $uuid,
        $name,
        $rankingPoints;

    public function __construct(string $uuid, string $name, ?int $rankingPoints)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->rankingPoints = $rankingPoints;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function rankingPoints(): int
    {
        return $this->rankingPoints;
    }
}
