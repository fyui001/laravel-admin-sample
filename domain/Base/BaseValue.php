<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoString;

abstract class BaseValue extends CoString
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
