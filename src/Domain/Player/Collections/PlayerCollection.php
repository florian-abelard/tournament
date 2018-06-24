<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player\Collections;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
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

    public function remove(Uuid $uuid): self
    {
        foreach ($this->players as $index => $player)
        {
            if ($player->uuid()->equals($uuid))
            {
                unset($this->players[$index]);
            }
        }

        return $this;
    }

    public function last(): ?Player
    {
        $last = end($this->players);

        if (!$last)
        {
            return null;
        }

        return $last;
    }

    public function shift(): ?Player
    {
        return array_shift($this->players);
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->players);
    }

    public function count(): int
    {
        return count($this->players);
    }

    public function sortByRankingPoints(): void
    {
        usort($this->players, function(Player $player1, Player $player2){

            $player1RankingPoints = $player1->rankingPoints();
            $player2RankingPoints = $player2->rankingPoints();

            if ($player1RankingPoints->equals($player2RankingPoints))
            {
                return 0;
            }

            return ($player1RankingPoints->greaterThan($player2RankingPoints)) ? -1 : 1;
        });
    }
}
