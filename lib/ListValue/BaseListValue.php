<?php

declare(strict_types=1);

namespace Lib\ListValue;

abstract class BaseListValue implements \IteratorAggregate, \ArrayAccess, \Countable
{
    protected $array;

    public function __construct(array $array)
    {
        $this->array = array_values($array);
    }

    public static function makeEmpty()
    {
        return new static([]);
    }

    public function count(): int
    {
        return count($this->array);
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->array[$offset] : null;
    }

    public function offsetExists($offset)
    {
        return isset($this->array[$offset]);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }

    public function isEmpty(): bool
    {
        return count($this->array) === 0;
    }

    public function map(\Closure $closure): array
    {
        $result = [];
        $iterator = $this->getIterator();
        foreach ($iterator as $item) {
            $result[] = $closure($item);
        }
        return $result;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }

    public function forEach(\Closure $closure)
    {
        $iterator = $this->getIterator();
        foreach ($iterator as $item) {
            $closure($item);
        }
    }

    public function reverse(): self
    {
        return new static(array_reverse($this->array));
    }

    public function filter(\Closure $closure): array
    {
        return array_filter($this->array, $closure);
    }

    public function limit(int $limit): self
    {
        return new static(array_slice($this->array, 0, $limit));
    }

    public function some(\Closure $closure): bool
    {
        return array_reduce($this->array, function ($carry, $item) use ($closure) {
            return $carry || $closure($item);
        }, false);
    }

    public function every(\Closure $closure): bool
    {
        return array_reduce($this->array, function ($carry, $item) use ($closure) {
            return $carry && $closure($item);
        }, true);
    }

    public function reduce(\Closure $closure, $initial)
    {
        return array_reduce($this->array, $closure, $initial);
    }

    public function toArray(): array
    {
        return $this->array;
    }
}
