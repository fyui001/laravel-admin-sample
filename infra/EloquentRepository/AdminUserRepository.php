<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\AdminUser\AdminUserList;
use Domain\AdminUser\AdminUserName;
use Domain\AdminUser\AdminUserRepository as AdminUserRepositoryInterface;
use Domain\AdminUser\AdminUser;
use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use Domain\Common\HashedPassword;
use Domain\Common\RawPositiveInteger;
use Domain\Exception\LogicException;
use Domain\Exception\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Infra\EloquentModels\AdminUser as AdminUserModel;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    public function get(AdminId $id): AdminUser
    {
        $model = AdminUserModel::where(['id' => $id->getRawValue()])
            ->first();
        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function getAdminUserList(): AdminUserList
    {
        /** @var Collection $collection */
        $collection = AdminUserModel::get();

        return new AdminUserList($collection->map(function(AdminUserModel $model) {
            return $model->toDomain();
        })->toArray());
    }

    public function getByUserId(AdminUserId $adminUserId): AdminUser
    {
        $model = AdminUserModel::where(['user_id' => $adminUserId->getRawValue()])->first();

        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDOmain();
    }

    public function create(
        AdminUserId $adminUserId,
        HashedPassword $password,
        AdminUserName $name,
        AdminUserRole $role,
        AdminUserStatus $status
    ): AdminUser {
        $model = new AdminUserModel();

        $model->user_id = $adminUserId->getRawValue();
        $model->password = $password->getRawValue();
        $model->name = $name->getRawValue();
        $model->role = $role->getValue()->getRawValue();
        $model->status = $status->getValue()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(AdminUser $adminUser): AdminUser
    {
        $model = AdminUserModel::where(['id' => $adminUser->getId()->getRawValue()])->first();

        $model->user_id = $adminUser->getUserId()->getRawValue();
        $model->password = $adminUser->getPassword()->getRawValue();
        $model->name = $adminUser->getName()->getRawValue();
        $model->role = $adminUser->getRole()->getValue()->getRawValue();
        $model->status = $adminUser->getStatus()->getValue()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function delete(AdminId $adminId): RawPositiveInteger
    {
        $model = AdminUserModel::where(['id' => $adminId->getRawValue()]);

        if (!$model) {
            throw new NotFoundException();
        }

        $result = $model->delete();

        if (!$result) {
            throw new LogicException();
        }

        return new RawPositiveInteger($result);
    }
}
