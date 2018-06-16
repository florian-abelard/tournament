<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Tournament\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Collections\TournamentCollection;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;
use Flo\Tournoi\Domain\Tournament\TournamentRepository;

class Memory implements TournamentRepository
{
    public
        $collection;

    public function __construct(array $tournaments = [])
    {
        $this->collection = new TournamentCollection($tournaments);
    }

    public function persist(Tournament $tournament): void
    {
        $this->collection->add($tournament);
    }

    public function findById(Uuid $uuid): ?Tournament
    {
        foreach ($this->collection as $tournament)
        {
            if ($tournament->uuid()->equals($uuid))
            {
                return $tournament;
            }
        }
        return null;
    }

    public function findAll(): TournamentCollection
    {
        return $this->collection;
    }

    public function remove(Uuid $uuid): void
    {
        $this->collection->remove($uuid);
    }

    public function buildDomainObject(array $result): Tournament
    {
        return new Tournament(
            new Uuid($result['uuid']),
            $result['name']
        );
    }
}
