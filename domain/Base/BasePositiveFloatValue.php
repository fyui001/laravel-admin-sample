<?php

namespace Domain\Base;

use Domain\Exception\InvalidArgumentException;
use Lib\Float\BasePositiveFloatValue as LibNonNegativeFloatValue;

abstract class BasePositiveFloatValue extends LibNonNegativeFloatValue
{
    public function __construct($value)
    {
        try {
            parent::__construct($value);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException();
        }
    }
}
