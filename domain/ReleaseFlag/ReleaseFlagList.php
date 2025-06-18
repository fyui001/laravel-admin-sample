<?php

declare(strict_types=1);

namespace Domain\ReleaseFlag;

use Domain\Base\BaseListValue;
use Domain\Exception\InvalidArgumentException;

class ReleaseFlagList extends BaseListValue
{
    public static function makeAllDefinedList(self $savedList): self
    {
        $allDefinedList = ReleaseFlagNameList::makeAllDefinedList()->map(
            function (ReleaseFlagName $releaseFlagName) use ($savedList) {
                try {
                    return $savedList->findByReleaseFlagName($releaseFlagName);
                } catch (InvalidArgumentException) {
                    return ReleaseFlag::makeDisabledByName($releaseFlagName);
                }
            }
        );

        return new self($allDefinedList->toArray());
    }

    public function isEnabledByName(ReleaseFlagName $targetReleaseFlagName): bool
    {
        $targetReleaseFlag = $this->findByReleaseFlagName($targetReleaseFlagName);
        return $targetReleaseFlag->isEnabled();
    }

    private function findByReleaseFlagName(ReleaseFlagName $targetReleaseFlagName): ReleaseFlag
    {
        $filteredList = $this->filter(function (ReleaseFlag $releaseFlag) use ($targetReleaseFlagName) {
            return $releaseFlag->equalsByName($targetReleaseFlagName);
        });

        if ($filteredList->count() === 0) {
            throw new InvalidArgumentException();
        }

        return $filteredList[array_key_first($filteredList->toArray())];
    }
}
