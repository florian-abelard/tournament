<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Group\DataTransferObjects;

class Group
{
    private
        $uuid,
        $stageUuid,
        $label,
        $placesNumber;

    public function __construct(string $uuid, string $stageUuid, int $placesNumber, string $label)
    {
        $this->uuid = $uuid;
        $this->stageUuid = $stageUuid;
        $this->placesNumber = $placesNumber;
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

    public function placesNumber(): int
    {
        return $this->placesNumber;
    }
}
