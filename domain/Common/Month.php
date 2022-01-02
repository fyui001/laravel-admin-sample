<?php
declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BasePositiveIntegerValue;
use Domain\Exception\InvalidArgumentException;

class Month extends BasePositiveIntegerValue
{
    // NOTE: 1始まり。1が一月
    public function __construct($value)
    {
        if ($value > 12) {
            throw new InvalidArgumentException();
        }
        if ($value == 0) {
            throw new InvalidArgumentException();
        }

        parent::__construct($value);
    }

    public static function optionList()
    {
        $list = [];
        foreach (
            range(4, 12 + 4) as $month) {
            // 4月始まりにする
            $startShifted = ($month - 1) % 12 + 1;
            $list[$startShifted] = (new Month($startShifted))->toJpString();
        }
        return $list;
    }

    public function toJpString(): string
    {
        return $this->value . '月';
    }
}
