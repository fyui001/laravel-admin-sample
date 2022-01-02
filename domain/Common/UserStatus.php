<?php

declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BaseEnum;

class UserStatus extends BaseEnum
{
    const STATUS_INVALID = 0;
    const STATUS_VALID = 1;

    public function displayName(): string
    {
        switch ($this->rawValue()) {
            case self::STATUS_INVALID:
                return '無効';
            case self::STATUS_VALID:
                return '有効';
        }
    }

    public static function getDisplayNameList(): array
    {
        return [
            self::STATUS_INVALID => '無効',
            self::STATUS_VALID => '有効',
        ];
    }
}
