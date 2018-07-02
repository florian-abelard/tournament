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
        $placesNumberInGroup;

    public function __construct(string $uuid, string $tournamentUuid, string $type, int $placesNumberInGroup)
    {
        $this->uuid = $uuid;
        $this->tournamentUuid = $tournamentUuid;
        $this->type = $type;
        $this->placesNumberInGroup = $placesNumberInGroup;
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

    public function placesNumberInGroup(): int
    {
        return $this->placesNumberInGroup;
    }
}
