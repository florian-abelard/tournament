<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\TournamentPlayer\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;

class TournamentPlayer
{
    private
        $playerUuid,
        $tournamentUuid;

    public function __construct(Uuid $playerUuid, Uuid $tournamentUuid)
    {
        $this->playerUuid = $playerUuid;
        $this->tournamentUuid = $tournamentUuid;
    }

}
