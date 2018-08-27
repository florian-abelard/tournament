<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Game\Entities;

use Flo\Tournoi\Domain\Game\ValueObjects\GameStatus;
use Flo\Tournoi\Domain\Player\Entities\Player;

class Game
{
    private
        $player1,
        $player2,
        $status,
        $maximumNumberOfSets,
        $winner,
        $sets;

    public function __construct(Player $player1, Player $player2, GameStatus $status)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->status = $status;

        // $this->sets = new SetCollection();
    }

    public function status(): GameStatus
    {
        return $this->status;
    }

    public function maximumNumberOfSets(): int
    {
        return $this->maximumNumberOfSets;
    }

    public function setMaximumNumberOfSets(int $maximumNumberOfSets): self
    {
        $this->maximumNumberOfSets = $maximumNumberOfSets;

        return $this;
    }

    public function winner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(Player $winner): self
    {
        $this->winner = $winner;

        return $this;
    }
}
