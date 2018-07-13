<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Group\DataTransferObjects;

class Group
{
    private
        $uuid,
        $stageUuid,
        $label,
        $numberOfPlaces;

    public function __construct(string $uuid, string $stageUuid, int $numberOfPlaces, string $label)
    {
        $this->uuid = $uuid;
        $this->stageUuid = $stageUuid;
        $this->numberOfPlaces = $numberOfPlaces;
        $this->label = $label;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function stageUuid(): string
    {
        return $this->stageUuid;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function numberOfPlaces(): int
    {
        return $this->numberOfPlaces;
    }
}
