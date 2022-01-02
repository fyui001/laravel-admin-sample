<?php
declare(strict_types=1);

namespace Domain\Base;

abstract class BaseBooleanValue
{

    private bool $bool;

    public function __construct(bool $bool)
    {
        $this->bool = $bool;
    }

    public function isTrue(): bool
    {
        return $this->bool;
    }

    public function isFalse(): bool
    {
        return !$this->isTrue();
    }

    public function rawValue(): bool
    {
        return $this->bool;
    }

}
