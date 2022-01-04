<?php
declare(strict_types=1);

namespace Lib\Float;

abstract class BaseFloatValue
{
    protected $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function rawValue(): float
    {
        return $this->value;
    }

    public function isPlus(): bool
    {
        return $this->rawValue() > 0;
    }

    public function isMinus(): bool
    {
        return $this->rawValue() < 0;
    }

    public function isEqualTo(self $another): bool
    {
        return abs($this->rawValue() - $another->rawValue()) < PHP_FLOAT_EPSILON;
    }

    public function isGreaterThanOrEqualTo(self $another): bool
    {
        return $this->rawValue() > $another->rawValue() || $this->isEqualTo($another);
    }

    public function isGreaterThan(self $another): bool
    {
        return $this->rawValue() > $another->rawValue();
    }

    public function isLessThanOrEqualTo(self $another): bool
    {
        return $this->rawValue() < $another->rawValue() || $this->isEqualTo($another);
    }

    public function isLessThan(self $another): bool
    {
        return $this->rawValue() < $another->rawValue();
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
