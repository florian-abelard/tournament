<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Stage\DataTransferObjects;
use Flo\Tournoi\Domain\Stage\ValueObjects\StageType;

class GroupStage
{
    private
        $uuid,
        $tournamentUuid,
        $type,
        $numberOfPlacesInGroup;

    public function __construct(string $uuid, string $tournamentUuid, string $type, int $numberOfPlacesInGroup)
    {
        $this->uuid = $uuid;
        $this->tournamentUuid = $tournamentUuid;
        $this->type = $type;
        $this->numberOfPlacesInGroup = $numberOfPlacesInGroup;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function tournamentUuid(): string
    {
        return $this->tournamentUuid;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function numberOfPlacesInGroup(): int
    {
        return $this->numberOfPlacesInGroup;
    }
}
