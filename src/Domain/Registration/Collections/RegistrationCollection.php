<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Registration\Collections;

use Flo\Tournoi\Domain\Registration\Entities\Registration;

class RegistrationCollection implements \IteratorAggregate, \Countable
{
    private
        $tournamentsPlayers;

    public function __construct(iterable $tournamentsPlayers = [])
    {
        $this->players = [];

        foreach($tournamentsPlayers as $tournamentPlayer)
        {
            if($tournamentPlayer instanceof Registration)
            {
                $this->add($tournamentPlayer);
            }
        }
    }

    public function add(Registration $tournamentPlayer): self
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
