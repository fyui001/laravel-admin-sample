<?php
declare(strict_types=1);

namespace Domain\Base;

use Domain\Exception\InvalidArgumentException;

abstract class BaseId
{
    protected $value;

    public function __construct(int $value)
    {
        if ($value < 1) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
    }

    public function equals(BaseId $another): bool
    {
        return $this->value === $another->value;
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
