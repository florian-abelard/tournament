<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Registration\Entities;

use DateTime;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;
use Flo\Tournoi\Persistence\Registration\DataTransferObjects as DTO;

class Registration
{
    private
        $playerUuid,
        $tournamentUuid,
        $registrationDate;

    public function __construct(Uuid $playerUuid, Uuid $tournamentUuid, DateTime $registrationDate = null)
    {
        $this->playerUuid = $playerUuid;
        $this->tournamentUuid = $tournamentUuid;
        if (!$registrationDate)
        {
            // $registrationDate = (new DateTime())->format('Y-m-d H:i:s');
            $registrationDate = new DateTime();
        }
        $this->registrationDate = $registrationDate;
    }

    public function playerUuid()
    {
        return $this->playerUuid;
    }

    public function tournamentUuid()
    {
        return $this->tournamentUuid;
    }

    public function registrationDate()
    {
        return $this->registrationDate;
    }

    public function toDTO(): DTO\Registration
    {
        return new DTO\Registration(
            $this->playerUuid->value(),
            $this->tournamentUuid->value(),
            $this->registrationDate->format('Y-m-d H:i:s')
        );
    }
}
