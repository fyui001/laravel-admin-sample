<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Base\BaseEnum;
use Domain\Common\ListValue;
use Domain\Common\RawString;


enum AdminUserRole: string implements BaseEnum
{
    case SYSTEM = 'SYSTEM';
    case ADMIN = 'ADMIN';
    case OPERATOR = 'OPERATOR';
    case NONE = 'NONE';


    public function displayName(): RawString
    {
        return match ($this) {
            self::SYSTEM => new RawString('システム管理者'),
            self::ADMIN => new RawString('管理者'),
            self::OPERATOR => new RawString('オペレーター'),
            self::NONE => new RawString('権限なし'),
        };
    }

    public static function displayNameList(): ListValue
    {
        return new ListValue([
            self::SYSTEM->getValue()->getRawValue() => new RawString('システム管理者'),
            self::ADMIN->getValue()->getRawValue() => new RawString('管理者'),
            self::OPERATOR->getValue()->getRawValue() => new RawString('オペレーター'),
            self::NONE->getValue()->getRawValue() => new RawString('権限なし'),
        ]);
    }

    public function isSystem(): bool
    {
        return match ($this) {
            self::SYSTEM => true,
            self::ADMIN, self::OPERATOR, self::NONE => false,
        };
    }

    public function isAdmin(): bool
    {
        return match ($this) {
            self::ADMIN => true,
            self::SYSTEM, self::OPERATOR, self::NONE => false,
        };
    }

    public function isOperator(): bool
    {
        return match ($this) {
            self::OPERATOR => true,
            self::SYSTEM, self::ADMIN, self::NONE => false,
        };
    }

    public function isNone(): bool
    {
        return match ($this) {
            self::NONE => true,
            self::SYSTEM, self::ADMIN, self::OPERATOR => false,
        };
    }

    public function getValue(): RawString
    {
        return new RawString($this->value);
    }
}
