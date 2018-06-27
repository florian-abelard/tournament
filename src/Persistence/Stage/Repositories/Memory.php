<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Stage\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
// use Flo\Tournoi\Domain\Stage\Collections\StageCollection;
use Flo\Tournoi\Domain\Stage\Entities\Stage;
use Flo\Tournoi\Domain\Stage\StageRepository;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlAbstract;

class Memory extends MysqlAbstract implements StageRepository
{
    public
        $collection;

    public function __construct(array $stages = [])
    {
        // $this->collection = new StageCollection($stages); // TODO
    }

    public function persist(Stage $stage): void
    {
        $this->collection->add($stage);
    }

    public function findById(Uuid $uuid): ?Stage
    {
        return null;
    }
}
