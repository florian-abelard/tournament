<?php

declare( strict_types = 1 );

namespace Flo\Tournoi\Domain\Core\Collections;

interface CollectionInterface extends \Countable, \IteratorAggregate, \ArrayAccess
{
    public function itemClassName() : string;
}
