<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;

abstract class Stage
{
    private
        $uuid,
        $tournamentUuid;

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
}
