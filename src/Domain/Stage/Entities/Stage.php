<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;

abstract class Stage
{
    private
        $uuid,
        $name,
        $players;

    public function __construct(Uuid $uuid, Uuid $tournamentUuid)
    {
        $this->uuid = $uuid;

        $players = new PlayerCollection();
    }

}
