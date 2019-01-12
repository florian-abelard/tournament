<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\ValueObjects;

use Flo\Tournoi\Domain\Match\Exceptions\InvalidMatchStatusException;

final class MatchStatus
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

    public function equals(MatchStatus $status): bool
    {
        return $this->value() === $status->value();
    }

    public function validate(string $status): void
    {
        if(!in_array($status, self::ALLOWED_STATUSES))
        {
            throw new InvalidMatchStatusException($status);
        }
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
