<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Stage\Collections;

use Flo\Tournoi\Domain\Core\Collections\Collection;
use Flo\Tournoi\Domain\Stage\Entities\Stage;

class StageCollection extends Collection
{
    public function __construct(iterable $items = [])
    {
        parent::__construct(Stage::class, $items);
    }

    public function add(Stage $stage): self
    {
        $this->items[] = $stage;

        return $this;
    }
}
