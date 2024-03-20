<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoBoolean;
use Domain\Common\ListValue;

abstract class BaseBooleanValue extends CoBoolean
{
    public function displayName(): string
    {
        return $this->getRawValue() ? 'はい' : 'いいえ';
    }

    public function displayValue(): string
    {
        return $this->getRawValue() ? 'TRUE' : 'FALSE';
    }

    public static function disPlayNameList(): ListValue
    {
        return new ListValue([
            0 => '無効',
            1 => '有効',
        ]);
    }

    final public function __toString(): string
    {
        return $this->displayValue();
    }
}
