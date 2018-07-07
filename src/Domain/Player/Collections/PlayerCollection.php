<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Player\Collections;

use Flo\Tournoi\Domain\Core\Collections\Collection;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Entities\Player;

class PlayerCollection extends Collection
{

    public function __construct(iterable $players = [])
    {
        parent::__construct(Player::class, $players);
    }

    public function add(Player $player): self
    {
        $this->items[] = $player;

        return $this;
    }

    public function remove(Uuid $uuid): self
    {
        foreach ($this->items as $index => $player)
        {
            if ($player->uuid()->equals($uuid))
            {
                unset($this->items[$index]);
            }
        }

        return $this;
    }

    public function last(): ?Player
    {
        $last = end($this->items);

        if (!$last)
        {
            return null;
        }

        return $last;
    }

    public function shift(): ?Player
    {
        return array_shift($this->items);
    }

    public function sortByRankingPoints(): void
    {
        usort($this->items, function(Player $player1, Player $player2){

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
