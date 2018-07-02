<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Stage\ValueObjects\StageType;

abstract class Stage
{
    protected
        $uuid,
        $tournamentUuid,
        $type;

    public function __construct(Uuid $uuid, Uuid $tournamentUuid)
    {
        $this->uuid = $uuid;
        $this->tournamentUuid = $tournamentUuid;
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function tournamentUuid(): Uuid
    {
        return $this->tournamentUuid;
    }

    public function type(): StageType
    {
        return $this->type;
    }

    public function setType(StageType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
