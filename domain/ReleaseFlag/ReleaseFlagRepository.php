<?php

declare(strict_types=1);

namespace Domain\ReleaseFlag;

interface ReleaseFlagRepository
{
    public function get(ReleaseFlagName $releaseFlagName): ReleaseFlag;
    public function getOnlyDefinedList(): ReleaseFlagList;
    public function getOnlyEnabledList(): ReleaseFlagList;
    public function upsert(ReleaseFlag $releaseFlag): void;
}
