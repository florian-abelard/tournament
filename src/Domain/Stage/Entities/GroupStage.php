<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Stage\Entities\Stage;

class GroupStage extends Stage
{
    private
        $groupPlacesNumber;

    public function __construct(Uuid $uuid, Uuid $tournamentUuid)
    {
        parent::__construct($uuid, $tournamentUuid);
    }

    public function groupPlacesNumber(): ?int
    {
        return $this->groupPlacesNumber;
    }

    public function setGroupPlacesNumber(int $number): self
    {
        $this->groupPlacesNumber = $number;

        return $this;
    }

}
