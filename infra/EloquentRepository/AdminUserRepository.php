<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\AdminUser\AdminUserList;
use Domain\AdminUser\AdminUserName;
use Domain\AdminUser\AdminUserRepository as AdminUserRepositoryInterface;
use Domain\AdminUser\AdminUser as AdminUserDomain;
use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use Domain\Common\HashedPassword;
use Domain\Exception\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Infra\EloquentModels\AdminUser;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    public function get(AdminId $id): AdminUserDomain
    {
        $model = AdminUser::where(['id' => $id->getRawValue()])
            ->first();
        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function getAdminUserList(): AdminUserList
    {
        /** @var Collection $collection */
        $collection = AdminUser::get();

        return new AdminUserList($collection->map(function(AdminUser $model) {
            return $model->toDomain();
        })->toArray());
    }

    public function getByUserId(AdminUserId $adminUserId): AdminUserDomain
    {
        $model = AdminUser::where([
            'user_id' => $adminUserId->getRawValue(),
            'status' => AdminUserStatus::VALID->getValue()->getRawValue(),
        ])->first();

        if (is_null($model)) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function create(
        AdminUserId $adminUserId,
        HashedPassword $password,
        AdminUserName $name,
        AdminUserRole $role,
        AdminUserStatus $status
    ): AdminUserDomain {
        $model = new AdminUser();

        $model->user_id = $adminUserId->getRawValue();
        $model->password = $password->getRawValue();
        $model->name = $name->getRawValue();
        $model->role = $role->getValue()->getRawValue();
        $model->status = $status->getValue()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(AdminUserDomain $adminUser): AdminUserDomain
    {
        $model = AdminUser::where(['id' => $adminUser->getId()->getRawValue()])->first();

        if (is_null($model)) {
            throw new NotFoundException();
        }

        $model->user_id = $adminUser->getUserId()->getRawValue();
        $model->password = $adminUser->getPassword()->getRawValue();
        $model->name = $adminUser->getName()->getRawValue();
        $model->role = $adminUser->getRole()->getValue()->getRawValue();
        $model->status = $adminUser->getStatus()->getValue()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function delete(AdminId $adminId): void
    {
        $model = AdminUser::where(['id' => $adminId->getRawValue()])->first();

        if (!$model) {
            throw new NotFoundException();
        }

        $model->status = AdminUserStatus::INVALID->getValue()->getRawValue();

        $model->save();
    }
}
