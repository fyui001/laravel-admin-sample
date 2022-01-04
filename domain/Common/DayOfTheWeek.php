<?php
declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BaseEnum;

class DayOfTheWeek extends BaseEnum
{
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;

    public function displayName(): string
    {
        switch ($this->rawValue()) {
            case self::SUNDAY:
                return '日曜日';
            case self::MONDAY:
                return '月曜日';
            case self::TUESDAY:
                return '火曜日';
            case self::WEDNESDAY:
                return '水曜日';
            case self::THURSDAY:
                return '木曜日';
            case self::FRIDAY:
                return '金曜日';
            case self::SATURDAY:
                return '土曜日';
        }
    }
}
