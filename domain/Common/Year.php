<?php

namespace Domain\Common;

use Domain\Base\BasePositiveIntegerValue;

class Year extends BasePositiveIntegerValue
{
    public static function optionList(): array
    {
        $now = CommonTime::now();
        $yearInt = $now->getYear()->rawValue();

        $list = [];
        foreach (range($yearInt, $yearInt - 100) as $year) {
            $list[$year] = $year . '年';
        }

        return $list;
    }

}
