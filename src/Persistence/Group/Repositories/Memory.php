<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Group\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Group\Entities\Group;
use Flo\Tournoi\Domain\Group\GroupRepository;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlAbstract;

class Memory extends MysqlAbstract implements GroupRepository
{
    public
        $collection;

    public function __construct(array $groups = [])
    {
        $this->collection = new GroupCollection($groups);
    }

    public function persist(Group $group): void
    {
        $this->collection->add($group);
    }

    public function findByStageId(Uuid $stageUuid): GroupCollection
    {
        return new GroupCollection();
    }
}
