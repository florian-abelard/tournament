<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Stage\Entities\Stage;

class GroupStage extends Stage
{
    private
        $placesNumberInGroup;

    public function __construct(Uuid $uuid, Uuid $tournamentUuid)
    {
        parent::__construct($uuid, $tournamentUuid);
    }

    public function placesNumberInGroup(): ?int
    {
        return $this->placesNumberInGroup;
    }

    public function setPlacesNumberInGroup(int $number): self
    {
        $this->placesNumberInGroup = $number;

        return $this;
    }

}
