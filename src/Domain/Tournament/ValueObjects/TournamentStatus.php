<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Tournament\ValueObjects;

use Flo\Tournoi\Domain\Tournament\Exceptions\InvalidTournamentStatusException;

final class TournamentStatus
{
    private const
        ALLOWED_STATUSES = ['upcoming', 'registering', 'running', 'finished', 'cancelled'];

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

    public function equals(TournamentStatus $status): bool
    {
        return $this->value() === $status->value();
    }

    public function validate(string $status): void
    {
        if(!in_array($status, self::ALLOWED_STATUSES))
        {
            throw new InvalidTournamentStatusException($status);
        }
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
