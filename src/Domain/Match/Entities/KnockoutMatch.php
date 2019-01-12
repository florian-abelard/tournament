<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;
use Flo\Tournoi\Domain\Core\ValueObjects\NullDateTime;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchType;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchStatus;
use Flo\Tournoi\Domain\Match\Entities\Match;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Match\DataTransferObjects as DTO;

class KnockoutMatch extends Match
{
    private
        $groupUuid;

    public function __construct(Uuid $uuid, Player $player1, Player $player2, Uuid $stageUuid)
    {
        parent::__construct(
            $uuid,
            $player1,
            $player2,
            $stageUuid
        );

        $this->setType(new MatchType(MatchType::TYPE_KNOCKOUT));
    }
}
