<?php

declare(strict_types=1);

namespace App\Services;

use Domain\ReleaseFlag\ReleaseFlag;
use Domain\ReleaseFlag\ReleaseFlagDomainService;
use Domain\ReleaseFlag\ReleaseFlagList;
use Domain\ReleaseFlag\ReleaseFlagName;

class ReleaseFlagService
{
    public function __construct(
        readonly private ReleaseFlagDomainService $releaseFlagDomainService,
    ) {
    }

    public function get(ReleaseFlagName $releaseFlagName): ReleaseFlag
    {
        return $this->releaseFlagDomainService->get($releaseFlagName);
    }

    public function getList(): ReleaseFlagList
    {
        return $this->releaseFlagDomainService->getAllDefinedList();
    }

    public function upsert(ReleaseFlag $releaseFlag): void
    {
        $this->releaseFlagDomainService->upsert($releaseFlag);
    }
}
