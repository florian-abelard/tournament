<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\Collections;

use Flo\Tournoi\Domain\Core\Collections\Collection;
use Flo\Tournoi\Domain\Match\Entities\Match;

class GroupMatchCollection extends Collection
{
    public function __construct(iterable $items = [])
    {
        parent::__construct(Match::class, $items);
    }

    public function add(Match $match): self
    {
        $this->items[] = $match;

        return $this;
    }

    public function last(): ?Match
    {
        $last = end($this->items);

        if (!$last)
        {
            return null;
        }

        return $last;
    }

    public function sortByPosition(): void
    {
        usort($this->items, function(Match $match1, Match $match2){

            if ($match1->position() === $match2->position())
            {
                return 0;
            }

            return ($match1->position() < $match2->position()) ? -1 : 1;
        });
    }
}
