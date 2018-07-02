<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\ValueObjects;

use Flo\Tournoi\Domain\Stage\Exceptions\InvalidStageTypeException;

final class StageType
{
    public const
        TYPE_GROUP = "group",
        TYPE_BRACKET = "bracket";

    private
        $type;

    public function __construct(string $type)
    {
        $this->validate($type);

        $this->type = $type;
    }

    public function value(): string
    {
        return $this->type;
    }

    public function equals(StageType $type): bool
    {
        return $this->value() === $type->value();
    }

    public function validate(string $type): void
    {
        if ($type != self::TYPE_GROUP && $type != self::TYPE_BRACKET)
        {
            throw new InvalidStageTypeException($type);
        }
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
