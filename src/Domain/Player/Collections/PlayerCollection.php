<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player\Collections;

use Flo\Tournoi\Domain\Player\Entities\Player;

class PlayerCollection implements \IteratorAggregate, \Countable
{
    private
        $players;

    public function __construct(iterable $players = [])
    {
        $this->players = [];

        foreach($players as $player)
        {
            if($player instanceof Player)
            {
                $this->add($player);
            }
        }
    }

    public function add(Player $player): self
    {
        $this->players[] = $player;

        return $this;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->players);
    }

    public function count(): int
    {
        return count($this->players);
    }
}
