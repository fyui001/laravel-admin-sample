<?php

declare(strict_types=1);

namespace Domain\News;

use Domain\Base\BaseEnum;

class Status extends BaseEnum
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

    public function isInvalid(): bool
    {
        return $this->is(self::STATUS_INVALID);
    }

    public function isValid(): bool
    {
        return $this->is(self::STATUS_VALID);
    }
}
