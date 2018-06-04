<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Registration\Collections;

use Flo\Tournoi\Domain\Registration\Entities\Registration;

class RegistrationCollection implements \IteratorAggregate, \Countable
{
    private
        $registrations;

    public function __construct(iterable $registrations = [])
    {
        $this->players = [];

        foreach($registrations as $registrations)
        {
            if($registrations instanceof Registration)
            {
                $this->add($registrations);
            }
        }
    }

    public function add(Registration $registrations): self
    {
        $this->registrations[] = $registrations;

        return $this;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->registrations);
    }

    public function count(): int
    {
        return count($this->registrations);
    }
}
