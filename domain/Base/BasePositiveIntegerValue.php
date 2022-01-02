<?php

namespace Domain\Base;

use Domain\Exception\InvalidArgumentException;

abstract class BasePositiveIntegerValue extends BaseIntValue
{
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException();
        }

        parent::__construct($value);
    }

    public static function makeZero()
    {
        return new static(0);
    }
}
