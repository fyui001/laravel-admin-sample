<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ReleaseFlag;

use Domain\ReleaseFlag\ReleaseFlag;
use Domain\ReleaseFlag\ReleaseFlagList;
use Domain\ReleaseFlag\ReleaseFlagName;
use Domain\ReleaseFlag\IsEnabled;
use Tests\TestCase;

class ReleaseFlagListTest extends TestCase
{
    public function testIsEnabledByName()
    {
        $releaseFlagList = $this->makeReleaseFlagListStub();

        $isEnabled = $releaseFlagList->isEnabledByName(ReleaseFlagName::TEST);
        self::assertTrue($isEnabled);
    }

    private function makeReleaseFlagListStub(): ReleaseFlagList
    {
        return new ReleaseFlagList(
            [
                new ReleaseFlag(
                    ReleaseFlagName::TEST,
                    new IsEnabled(true),
                ),
            ],
        );
    }
}