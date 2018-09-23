<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Game\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Collections\GroupGameCollection;
use Flo\Tournoi\Domain\Game\Entities\Game;
use Flo\Tournoi\Domain\Game\GameRepository;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlAbstract;

class Memory extends MysqlAbstract implements GameRepository
{
    public
        $collection;

    public function __construct(array $games = [])
    {
        $this->collection = new GroupGameCollection($games);
    }

    public function persist(Game $game): void
    {
        $this->collection->add($game);
    }

    public function findByGroupId(Uuid $uuid): GroupGameCollection
    {
        return new GroupGameCollection();
    }
}
