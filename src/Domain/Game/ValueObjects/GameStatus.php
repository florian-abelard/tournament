<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\ValueObjects;

use Flo\Tournoi\Domain\Game\Exceptions\InvalidGameStatusException;

final class GameStatus
{
    private const
        ALLOWED_STATUSES = ['upcoming', 'running', 'finished'];

    private
        $status;

    public function __construct(string $status)
    {
        $this->validate($status);

        $this->status = $status;
    }

    public function value(): string
    {
        return $this->status;
    }

    public function equals(GameStatus $status): bool
    {
        return $this->value() === $status->value();
    }

    public function validate(string $status): void
    {
        if(!in_array($status, self::ALLOWED_STATUSES))
        {
            throw new InvalidGameStatusException($status);
        }
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
