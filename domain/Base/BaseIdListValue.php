<?php
declare(strict_types=1);

namespace Domain\Base;

abstract class BaseIdListValue extends BaseListValue
{
    public function toArray(): array
    {
        return $this->map(function ($id) {
            /** @var BaseId $id */
            return $id->rawValue();
        });
    }

    public function contains($otherId): bool
    {
        foreach ($this->array as $id) {
            /** @var BaseId $id */
            if ($id->equals($otherId)) {
                return true;
            }
        }

        return false;
    }

}
