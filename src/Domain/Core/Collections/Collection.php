<?php

declare( strict_types = 1 );

namespace Flo\Tournoi\Domain\Core\Collections;

use Flo\Tournoi\Domain\Core\Collections\CollectionInterface;

abstract class Collection implements CollectionInterface
{
    protected
        $itemClassName,
        $items = [];

    public function __construct(string $itemClassName, iterable $items = [])
    {
        $this->itemClassName = $itemClassName;

        foreach($items as $item)
        {
            if($item instanceof $itemClassName)
            {
                $this->add($item);
            }
            else {
                // TODO Exception
            }
        }
    }

    public function itemClassName() : string
    {
        return $this->itemClassName;
    }

    /*
     * Implements countable
     */

    public function count(): int
    {
        return count($this->items);
    }

    /*
     * Implements IteratorAggregate
     */

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->items);
    }

    /*
     * Implements ArrayAccess
     */

     public function offsetSet($offset, $value)
    {
        if (is_null($offset))
        {
            $this->items[] = $value;
        }
        else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset))
        {
            unset($this->items[$offset]);
        }
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset))
        {
            return $this->items[$offset];
        }
        else {
            return null;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }
}
