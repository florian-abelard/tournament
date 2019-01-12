<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Match\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\Collections\GroupMatchCollection;
use Flo\Tournoi\Domain\Match\Entities\Match;
use Flo\Tournoi\Domain\Match\MatchRepository;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlAbstract;

class Memory extends MysqlAbstract implements MatchRepository
{
    public
        $collection;

    public function __construct(array $matches = [])
    {
        $this->collection = new GroupMatchCollection($matches);
    }

    public function persist(Match $match): void
    {
        $this->collection->add($match);
    }

    public function findByGroupId(Uuid $uuid): GroupMatchCollection
    {
        return new GroupMatchCollection();
    }
}
