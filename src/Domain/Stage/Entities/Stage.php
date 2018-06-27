<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;

abstract class Stage
{
    public const
        TYPE_GROUP = "group",
        TYPE_BRACKET = "bracket";

    protected
        $uuid,
        $tournamentUuid,
        $type;

    public function __construct(Uuid $uuid, Uuid $tournamentUuid)
    {
        $this->uuid = $uuid;
        $this->tournamentUuid = $tournamentUuid;
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function tournamentUuid(): Uuid
    {
        return $this->tournamentUuid;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function setType($type): self
    {
        if ($type != self::TYPE_GROUP && $type != self::TYPE_BRACKET)
        {
            throw new \DomainException(sprintf('Invalid group type : "%s"', $type));
        }
        $this->type = $type;

        return $this;
    }
}
