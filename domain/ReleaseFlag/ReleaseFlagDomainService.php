<?php

namespace Domain\ReleaseFlag;

use Domain\Exception\NotFoundException;

readonly class ReleaseFlagDomainService
{
    public function __construct(
        private ReleaseFlagRepository $releaseFlagRepository,
    ) {
    }

    public function get(ReleaseFlagName $releaseFlagName): ReleaseFlag
    {
        try {
            return $this->releaseFlagRepository->get($releaseFlagName);
        } catch (NotFoundException) {
            return ReleaseFlag::makeDisabledByName($releaseFlagName);
        }
    }

    public function getAllDefinedList(): ReleaseFlagList
    {
        $savedList = $this->releaseFlagRepository->getOnlyDefinedList();

        return ReleaseFlagList::makeAllDefinedList($savedList);
    }

    public function upsert(ReleaseFlag $releaseFlag): void
    {
        $this->releaseFlagRepository->upsert($releaseFlag);
    }
}
