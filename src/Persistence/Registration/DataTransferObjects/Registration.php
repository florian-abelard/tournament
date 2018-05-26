<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Registration\DataTransferObjects;

use DateTime;

class Registration
{
    private
        $playerUuid,
        $tournamentUuid,
        $registrationDate;

    public function __construct(string $playerUuid, string $tournamentUuid, string $registrationDate)
    {
        $this->playerUuid = $playerUuid;
        $this->tournamentUuid = $tournamentUuid;
        $this->registrationDate = $registrationDate;
    }

    public function playerUuid(): string
    {
        return $this->playerUuid;
    }

    public function tournamentUuid(): string
    {
        return $this->tournamentUuid;
    }

    public function registrationDate(): string
    {
        return $this->registrationDate;
    }
}
