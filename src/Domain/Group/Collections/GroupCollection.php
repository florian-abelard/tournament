<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Group\Collections;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\Entities\Group;

class GroupCollection implements \IteratorAggregate, \Countable
{
    private
        $groups;

    public function __construct(iterable $groups = [])
    {
        $this->groups = [];

        foreach($groups as $group)
        {
            if($group instanceof Group)
            {
                $this->add($group);
            }
        }
    }

    public function add(Group $group): self
    {
        $this->groups[] = $group;

        return $this;
    }

    public function remove(Uuid $uuid): self
    {
        foreach ($this->groups as $index => $group)
        {
            if ($group->uuid()->equals($uuid))
            {
                unset($this->groups[$index]);
            }
        }

        return $this;
    }

    public function last(): ?Group
    {
        $last = end($this->groups);

        if (!$last)
        {
            return null;
        }

        return $last;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->groups);
    }

    public function count(): int
    {
        return count($this->groups);
    }
}
