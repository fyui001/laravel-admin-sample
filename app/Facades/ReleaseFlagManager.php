<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ReleaseFlagManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ReleaseFlagManager';
    }
}
