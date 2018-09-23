<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\ValueObjects;

use Flo\Tournoi\Domain\Game\Exceptions\InvalidGameTypeException;

final class GameType
{
    public const
        TYPE_GROUP = "group",
        TYPE_KNOCKOUT = "knockout";

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

    public function equals(GameType $type): bool
    {
        return $this->value() === $type->value();
    }

    public function validate(string $type): void
    {
        if ($type != self::TYPE_GROUP && $type != self::TYPE_KNOCKOUT)
        {
            throw new InvalidGameTypeException($type);
        }
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
