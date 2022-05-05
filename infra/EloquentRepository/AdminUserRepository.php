<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\AdminUser\AdminUserHashedPassword;
use Domain\AdminUser\AdminUserName;
use Domain\AdminUser\AdminUserRepository as AdminUserRepositoryInterface;
use Domain\AdminUser\AdminUser as AdminUserDomain;
use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use Domain\Exception\NotFoundException;
use Infra\EloquentModels\AdminUser;
use Infra\EloquentModels\AdminUser as AdminUserModel;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    public function get(AdminId $id): AdminUserDomain
    {
        $model = AdminUserModel::where(['id' => $id->getRawValue()])
            ->first();
        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function getPaginate(): LengthAwarePaginator
    {
        return AdminUserModel::paginate(15);
    }

    public function create(
        AdminUserId $adminUserId,
        AdminUserHashedPassword $password,
        AdminUserName $name,
        AdminUserRole $role,
        AdminUserStatus $status
    ): AdminUserDomain {
        $model = new AdminUserModel();

        $model->user_id = $adminUserId->getRawValue();
        $model->password = $password->getRawValue();
        $model->name = $name->getRawValue();
        $model->role = $role->getValue()->getRawValue();
        $model->status = $status->getValue()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(
        AdminId $id,
        AdminUserId $adminUserId,
        AdminUserHashedPassword $password,
        AdminUserName $name,
        AdminUserRole $role,
        AdminUserStatus $status
    ): AdminUserDomain {
        $model = AdminUserModel::where('id', $id)->first();

        $model->user_id = $adminUserId->getRawValue();
        $model->password = $password->getRawValue();
        $model->name = $name->getRawValue();
        $model->role = $role->getValue()->getRawValue();
        $model->status = $status->getValue()->getRawValue();
        $model->save();

        return $model->toDomain();
    }

    public function delete(AdminId $id): bool
    {
        $model = AdminUser::where('id', $id)->first();
        if (!$model) {
            throw new NotFoundException();
        }

        return $model->delete();
    }
}
