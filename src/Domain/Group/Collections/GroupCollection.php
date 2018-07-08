<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Group\Collections;

use Flo\Tournoi\Domain\Core\Collections\Collection;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\Entities\Group;

class GroupCollection extends Collection
{
    public function __construct(iterable $items = [])
    {
        parent::__construct(Group::class, $items);
    }

    public function add(Group $group): self
    {
        $this->items[] = $group;

        return $this;
    }

    public function last(): ?Group
    {
        $last = end($this->items);

        if (!$last)
        {
            return null;
        }

        return $last;
    }
}
