<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Stage\Entities\Stage;
use Flo\Tournoi\Domain\Stage\ValueObjects\StageType;
use Flo\Tournoi\Persistence\Stage\DataTransferObjects as DTO;

class GroupStage extends Stage
{
    private
        $numberOfPlacesInGroup;

    public function __construct(Uuid $uuid, Uuid $tournamentUuid)
    {
        parent::__construct($uuid, $tournamentUuid);

        $this->setType(new StageType(StageType::TYPE_GROUP));
    }

    public function numberOfPlacesInGroup(): ?int
    {
        return $this->numberOfPlacesInGroup;
    }

    public function setNumberOfPlacesInGroup(int $number): self
    {
        $this->numberOfPlacesInGroup = $number;

        return $this;
    }

    public function toDTO(): DTO\GroupStage
    {
        return new DTO\GroupStage(
            $this->uuid->value(),
            $this->tournamentUuid->value(),
            $this->type->value(),
            $this->numberOfPlacesInGroup
        );
    }
}
