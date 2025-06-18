<?php

declare(strict_types=1);

namespace Domain\ReleaseFlag;

use Domain\Base\BaseEnum;
use Domain\Common\RawString;

enum ReleaseFlagName: string implements BaseEnum
{
    case TEST = '1993_03_16_takada_yuki_test_flag';

    public function getValue(): RawString
    {
        return new RawString($this->value);
    }

    public function displayName(): RawString
    {
        return $this->getValue();
    }

    public static function getValueList(): ReleaseFlagNameList
    {
        $constants = ReleaseFlagName::cases();

        $array = [];
        foreach ($constants as $key => $value) {
            /** @var self $value */
            if (!is_string($value->getValue()->getRawValue())) {
                continue;
            }
            $array[] = $value->getValue()->getRawValue();
        }

        return new ReleaseFlagNameList($array);
    }
}
