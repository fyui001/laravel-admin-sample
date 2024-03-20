<?php

declare(strict_types=1);

namespace Domain\News;

use Domain\Base\BaseEnum;
use Domain\Common\ListValue;
use Domain\Common\RawString;

enum Status: string implements BaseEnum
{
    case INVALID = 'INVALID';
    case VALID = 'VALID';

    public function displayName(): RawString
    {
        return match ($this) {
            self::INVALID => new RawString('無効'),
            self::VALID => new RawString('有効'),
        };
    }

    public static function displayNameList(): ListValue
    {
        return new ListValue([
            self::INVALID->getValue()->getRawValue() => new RawString('無効'),
            self::VALID->getValue()->getRawValue() => new RawString('有効'),
        ]);
    }

    public function getValue(): RawString
    {
        return new RawString($this->value);
    }
}
