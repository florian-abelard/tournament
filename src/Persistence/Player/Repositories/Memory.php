<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Player\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\PlayerRepository;

class Memory implements PlayerRepository
{
    public
        $collection;

    public function __construct(array $players = [])
    {
        $this->collection = new PlayerCollection($players);
    }

    public function persist(Player $player): void
    {
        $this->collection->add($player);
    }

    public function findById(Uuid $uuid): ?Player
    {
        foreach ($this->collection as $player)
        {
            if ($player->uuid == $id)
            {
                return $player;
            }
        }
        return null;
    }

    public function findAll(): iterable
    {
        return [];
    }

    public function remove(Uuid $uuid): void
    {

    }
}
