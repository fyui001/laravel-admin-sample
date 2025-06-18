<?php

declare(strict_types=1);

namespace Domain\ReleaseFlag;

use Domain\Base\BaseListValue;

class ReleaseFlagNameList extends BaseListValue
{
    public static function makeAllDefinedList(): self
    {
        $array = array_map(static function (string $val): ReleaseFlagName {
            return ReleaseFlagName::tryFrom($val);
        }, ReleaseFlagName::getValueList()->toArray());

        return new self($array);
    }
}
