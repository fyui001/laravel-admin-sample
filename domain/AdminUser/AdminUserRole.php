<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Courage\CoInt\CoInteger;
use Courage\CoList;
use Courage\CoString;
use Domain\Base\BaseEnum;

enum AdminUserRole: int implements BaseEnum
{
    case ROLE_SYSTEM = 1;
    case ROLE_ADMIN = 2;
    case ROLE_USER = 3;

    public function displayName(): Costring
    {
        return match($this) {
            self::ROLE_SYSTEM => new CoString('システム管理者'),
            self::ROLE_ADMIN => new CoString('管理者'),
            self::ROLE_USER => new Costring('一般ユーザー'),
        };
    }

    public static function displayNameList(): CoList
    {
        return new CoList([
            self::ROLE_SYSTEM->getValue()->getRawValue() => new CoString('システム管理者'),
            self::ROLE_ADMIN->getValue()->getRawValue() => new CoString('管理者'),
            self::ROLE_USER->getValue()->getRawValue() => new Costring('一般ユーザー'),
        ]);
    }

    public function isSystem(): bool
    {
        return match($this) {
            self::ROLE_SYSTEM => true,
            default => false,
        };
    }

    public function getValue(): CoInteger
    {
        return new CoInteger($this->value);
    }
}
