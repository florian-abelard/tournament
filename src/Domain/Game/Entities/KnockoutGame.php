<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;
use Flo\Tournoi\Domain\Core\ValueObjects\NullDateTime;
use Flo\Tournoi\Domain\Game\ValueObjects\GameType;
use Flo\Tournoi\Domain\Game\ValueObjects\GameStatus;
use Flo\Tournoi\Domain\Game\Entities\Game;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Game\DataTransferObjects as DTO;

class KnockoutGame extends Game
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

        $this->setType(new GameType(GameType::TYPE_KNOCKOUT));
    }
}
