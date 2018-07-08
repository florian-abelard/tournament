<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Registration\Collections;

use Flo\Tournoi\Domain\Core\Collections\Collection;
use Flo\Tournoi\Domain\Registration\Entities\Registration;

class RegistrationCollection extends Collection
{
    public function __construct(iterable $items = [])
    {
        parent::__construct(Registration::class, $items);
    }

    public function add(Registration $items): self
    {
        $this->items[] = $items;

        return $this;
    }
}
