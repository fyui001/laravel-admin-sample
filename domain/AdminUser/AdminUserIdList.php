<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Base\BaseListValue;

class AdminUserIdList extends BaseListValue
{
    public static function mergeAll(array $adminIdListArray)
    {
        $array = [];
        foreach ($adminIdListArray as $adminIdList) {
            $array = array_merge($array, $adminIdList->toArray());
        }
        $duplicated = new AdminUserIdList($array);
        return $duplicated->excludeDuplicates();
    }

    private function excludeDuplicates(): AdminUserIdList
    {
        $hashMap = [];
        $filtered = $this->filter(function (AdminId $id) use ($hashMap) {
            if (isset($hashMap[$id->rawValue()])) {
                return false;
            }
            $hashMap[$id->rawValue()] = true;
            return true;
        });
        return new AdminUserIdList($filtered);
    }

    public function toRawIdList(): array
    {
        return $this->map(function (AdminId $item) {
            return $item->rawValue();
        });
    }
}
