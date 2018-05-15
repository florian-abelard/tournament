<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Tournament\Collections;

use Flo\Tournoi\Domain\Tournament\Entities\Tournament;

class TournamentCollection implements \IteratorAggregate, \Countable
{
    private
        $tournaments;

    public function __construct(iterable $tournaments = [])
    {
        $this->tournaments = [];

        foreach($tournaments as $tournament)
        {
            if($tournament instanceof Tournament)
            {
                $this->add($tournament);
            }
        }
    }

    public function add(Tournament $tournament): self
    {
        $this->tournaments[] = $tournament;

        return $this;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->tournaments);
    }

    public function count(): int
    {
        return count($this->tournaments);
    }
}
