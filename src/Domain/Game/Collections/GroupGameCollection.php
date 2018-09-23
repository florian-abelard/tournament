<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Collections;

use Flo\Tournoi\Domain\Core\Collections\Collection;
use Flo\Tournoi\Domain\Game\Entities\Game;

class GroupGameCollection extends Collection
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

    public function sortByPosition(): void
    {
        usort($this->items, function(Game $game1, Game $game2){

            if ($game1->position() === $game2->position())
            {
                return 0;
            }

            return ($game1->position() < $game2->position()) ? -1 : 1;
        });
    }
}
