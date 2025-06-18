<?php

declare(strict_types=1);

namespace App\ReleaseFlag;

use Domain\ReleaseFlag\ReleaseFlagDomainService;
use Domain\ReleaseFlag\ReleaseFlagList;
use Domain\ReleaseFlag\ReleaseFlagName;

class ReleaseFlagManager
{
    private ReleaseFlagList $releaseFlagList;

    public function __construct(
        readonly private ReleaseFlagDomainService $domainService,
    ) {
        $this->releaseFlagList = ReleaseFlagList::makeEmpty();
    }

    private function isEnabledByName(ReleaseFlagName $releaseFlagName): bool
    {
        if ($this->releaseFlagList->isEmpty()) {
            $this->releaseFlagList = $this->domainService->getAllDefinedList();
        }

        return $this->releaseFlagList->isEnabledByName($releaseFlagName);
    }

    /**
     * @deprecated Unitテストから参照する用なので普段は使わないでください
     */
    public function isTestFlagEnabled(): bool
    {
        return $this->isEnabledByName(ReleaseFlagName::TEST);
    }
}
