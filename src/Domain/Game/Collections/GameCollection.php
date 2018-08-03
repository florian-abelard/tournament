<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Collections;

use Flo\Tournoi\Domain\Core\Collections\Collection;
use Flo\Tournoi\Domain\Game\Entities\Game;

class GameCollection extends Collection
{
    public function __construct(iterable $items = [])
    {
        parent::__construct(Game::class, $items);
    }

    public function add(Game $game): self
    {
        $this->items[] = $game;

        return $this;
    }

    public function last(): ?Game
    {
        $last = end($this->items);

        if (!$last)
        {
            return null;
        }

        return $last;
    }
}
