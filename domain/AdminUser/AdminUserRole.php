<?php
declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Base\BaseEnum;

class AdminUserRole extends BaseEnum
{
    const ROLE_SYSTEM = 1;
    const ROLE_ADMIN = 2;
    const ROLE_USER = 3;

    public function displayName(): string
    {
        switch ($this->rawValue()) {
            case self::ROLE_SYSTEM:
                return 'システム管理者';
            case self::ROLE_ADMIN:
                return '管理者';
            case self::ROLE_USER:
                return '一般ユーザー';
        }
    }

    public static function getDisplayNameList(): array
    {
        return [
            self::ROLE_SYSTEM => 'システム管理者',
            self::ROLE_ADMIN => '管理者',
            self::ROLE_USER => '一般ユーザー',
        ];
    }

    public function isSystem(): bool
    {
        return $this->is(self::ROLE_SYSTEM);
    }

    public function isAdmin(): bool
    {
        return $this->is(self::ROLE_ADMIN);
    }

    public function isUser():bool
    {
        return $this->is(self::ROLE_USER);
    }

    public static function getAdminType(): self
    {
        return new self(self::ROLE_ADMIN);
    }

    public static function getSystemType(): self
    {
        return new self(self::ROLE_SYSTEM);
    }
}
