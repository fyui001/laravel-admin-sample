<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Base\BaseListValue;
use Domain\Exception\LogicException;

class AdminUserList extends BaseListValue
{
    /** @var AdminUser[] */
    protected $array;

    public function toArray(): array
    {
        $array = [];
        foreach ($this->array as $item) {
            $array[] = $item->toArray();
        }

        return $array;
    }

    public function getById(AdminUserId $id): AdminUser
    {
        foreach ($this->array as $admin) {
            if ($admin->id()->equals($id)) {
                return $admin;
            }
        }

        throw new LogicException();
    }

    public function toOptionList(): array
    {
        $array=[];
        foreach ($this->array as $admin) {
            $array[$admin->id()->rawValue()] = $admin->getName()->rawValue();
        }

        return $array;
    }
}
