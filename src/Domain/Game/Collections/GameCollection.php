<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Collections;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Entities\Game;

class GameCollection implements \IteratorAggregate, \Countable
{
    private
        $games;

    public function __construct(iterable $games = [])
    {
        $this->games = [];

        foreach($games as $game)
        {
            if($game instanceof Game)
            {
                $this->add($game);
            }
        }
    }

    public function add(Game $game): self
    {
        $this->games[] = $game;

        return $this;
    }

    public function remove(Uuid $uuid): self
    {
        foreach ($this->games as $index => $game)
        {
            if ($game->uuid()->equals($uuid))
            {
                unset($this->games[$index]);
            }
        }

        return $this;
    }

    public function last(): ?Game
    {
        $last = end($this->games);

        if (!$last)
        {
            return null;
        }

        return $last;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->games);
    }

    public function count(): int
    {
        return count($this->games);
    }
}
