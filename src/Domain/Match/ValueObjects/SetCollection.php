<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Match\ValueObjects;

use Flo\Tournoi\Domain\Core\Collections\Collection;

class SetCollection extends Collection
{
    public function __construct(iterable $items = [])
    {
        parent::__construct(Set::class, $items);
    }

    public function add(Set $set): self
    {
        $this->items[] = $set;

        return $this;
    }
}
