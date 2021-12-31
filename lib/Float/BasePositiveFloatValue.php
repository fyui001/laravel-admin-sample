<?php
declare(strict_types=1);

namespace Lib\Float;

abstract class BasePositiveFloatValue extends BaseFloatValue
{
    public function __construct($value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException();
        }

        parent::__construct($value);
    }
}
