<?php

namespace Domain\Base;

abstract class BaseIntValue extends BaseValue
{
    protected $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function rawValue(): int
    {
        return $this->value;
    }

    public function getFormattedNumber(): string
    {
        return number_format($this->rawValue());
    }

    public function isZero(): bool
    {
        return $this->rawValue() === 0;
    }

    public function isOne(): bool
    {
        return $this->rawValue() === 1;
    }

    public function isPlus(): bool
    {
        return $this->rawValue() > 0;
    }

    public function isMinus(): bool
    {
        return $this->rawValue() < 0;
    }

    public function equals(BaseIntValue $another): bool
    {
        return $this->rawValue() === $another->rawValue();
    }

    public function greaterThanOrEqual(BaseIntValue $another): bool
    {
        return $this->rawValue() >= $another->rawValue();
    }

    public function greaterThan(BaseIntValue $another): bool
    {
        return $this->rawValue() > $another->rawValue();
    }

    public function lessThanOrEqual(BaseIntValue $another): bool
    {
        return $this->rawValue() <= $another->rawValue();
    }

    public function lessThan(BaseIntValue $another): bool
    {
        return $this->rawValue() < $another->rawValue();
    }

    public function increment(): self
    {
        return $this->add(new static(1));
    }

    public function add(self $another): self
    {
        return new static($this->value + $another->rawValue());
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
