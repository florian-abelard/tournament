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
            if ($player->uuid->equals($uuid))
            {
                return $player;
            }
        }
        return null;
    }

    public function findAll(): PlayerCollection
    {
        return $this->collection;
    }

    public function findByTournamentId(Uuid $tournamentUuid): PlayerCollection
    {
        $results = new PlayerCollection;

        foreach($this->collection as $player)
        {
            foreach($player->registrations as $registration)
            {
                if($registration->tournamentUuid()->equals($tournamentUuid))
                {
                    $results->add($player);
                }
            }
        }

        return $results;
    }

    public function findNotInTournament(Uuid $tournamentUuid): PlayerCollection
    {
        return new PlayerCollection;
    }

    public function remove(Uuid $uuid): void
    {

    }

    public function buildDomainObject(array $result): Player
    {
        return new Player(
            new Uuid($result['uuid']),
            $result['name']
        );
    }
}
