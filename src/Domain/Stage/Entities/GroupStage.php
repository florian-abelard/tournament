<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Stage\Entities\Stage;
use Flo\Tournoi\Persistence\Stage\DataTransferObjects as DTO;

class GroupStage extends Stage
{
    private
        $placesNumberInGroup;

    public function __construct(Uuid $uuid, Uuid $tournamentUuid)
    {
        parent::__construct($uuid, $tournamentUuid);

        $this->setType(parent::TYPE_GROUP);
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

    public function toDTO(): DTO\GroupStage
    {
        return new DTO\GroupStage(
            $this->uuid->value(),
            $this->tournamentUuid->value(),
            $this->type,
            $this->placesNumberInGroup
        );
    }
}
