<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\TournamentPlayer\Collections;

use Flo\Tournoi\Domain\TournamentPlayer\Entities\TournamentPlayer;

class TournamentPlayerCollection implements \IteratorAggregate, \Countable
{
    private
        $tournamentsPlayers;

    public function __construct(iterable $tournamentsPlayers = [])
    {
        $this->players = [];

        foreach($tournamentsPlayers as $tournamentPlayer)
        {
            if($tournamentPlayer instanceof TournamentPlayer)
            {
                $this->add($tournamentPlayer);
            }
        }
    }

    public function add(TournamentPlayer $tournamentPlayer): self
    {
        $this->tournamentPlayer[] = $tournamentPlayer;

        return $this;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->tournamentPlayer);
    }

    public function count(): int
    {
        return count($this->tournamentPlayer);
    }
}
