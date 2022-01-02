<?php
declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BasePositiveIntegerValue;

class Day extends BasePositiveIntegerValue
{
    public function __construct($value)
    {
        parent::__construct($value);
    }

    public function isFirstDay(): bool
    {
        return $this->rawValue() === 1;
    }
}
