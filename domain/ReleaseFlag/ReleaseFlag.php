<?php

declare(strict_types=1);

namespace Domain\ReleaseFlag;

use Domain\Common\RawString;

readonly class ReleaseFlag
{
    public function __construct(
        private ReleaseFlagName $releaseFlagName,
        private IsEnabled $isEnabled,
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled->getRawValue();
    }

    public function getKeyName(): ReleaseFlagName
    {
        return $this->releaseFlagName;
    }

    public function displayName(): RawString
    {
        return $this->releaseFlagName->displayName();
    }

    public function displayIsEnabled(): string
    {
        return $this->isEnabled->displayName();
    }

    public static function makeDisabledByName(ReleaseFlagName $releaseFlagName): self
    {
        return new self($releaseFlagName, IsEnabled::createFalse());
    }

    public function equalsByName(ReleaseFlagName $releaseFlagName): bool
    {
        return $this->releaseFlagName->getValue()->isEqual($releaseFlagName->getValue());
    }
}
