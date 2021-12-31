<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\AdminUser\AdminRepository as AdminUserRepositoryInterface;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUser as AdminUserDomain;
use Domain\Common\PeopleName;
use Infra\EloquentModels\AdminUser as AdminUserModel;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    public function get(AdminUserId $id): AdminUserDomain
    {
        // TODO: Implement get() method.
    }

    public function getList(): LengthAwarePaginator
    {
        return AdminUserModel::paginate(15);
    }

    public function create(AdminUserDomain $adminUser)
    {
        // TODO: Implement create() method.
    }

    public function update(AdminUserId $id, PeopleName $name)
    {
        // TODO: Implement update() method.
    }
}
