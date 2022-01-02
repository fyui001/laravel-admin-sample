<?php
declare(strict_types=1);

namespace Domain\Base;

use Domain\Exception\InvalidArgumentException;

abstract class BaseId extends BasePositiveIntegerValue
{
    protected $value;

    public function __construct(int $value)
    {
        parent::__construct($value);
        if ($value < 1) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
    }

    public function rawValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
