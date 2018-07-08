<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Tournament\Collections;

use Flo\Tournoi\Domain\Core\Collections\Collection;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;

class TournamentCollection extends Collection
{
    public function __construct(iterable $items = [])
    {
        parent::__construct(Tournament::class, $items);
    }

    public function add(Tournament $tournament): self
    {
        $this->items[] = $tournament;

        return $this;
    }

    public function remove(Uuid $uuid): self
    {
        foreach ($this->items as $index => $tournament)
        {
            if ($tournament->uuid()->equals($uuid))
            {
                unset($this->items[$index]);
            }
        }

        return $this;
    }
}
