<?php

declare(strict_types=1);

namespace Domain\ReleaseFlag;

use Domain\Base\BaseBooleanValue;

class IsEnabled extends BaseBooleanValue
{
    public function displayName(): string
    {
        return $this->isTrue() ? 'ON' : 'OFF';
    }
}
