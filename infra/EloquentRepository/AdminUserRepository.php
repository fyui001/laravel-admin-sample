<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\AdminUser\AdminUserRepositoryArgument\AdminUserArgumentForCreate;
use Domain\AdminUser\AdminUserRepository as AdminUserRepositoryInterface;
use Domain\AdminUser\AdminUser as AdminUserDomain;
use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\Common\HashedPassword;
use Domain\Common\PeopleName;
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
        $model = AdminUserModel::where(['id' => $id->rawValue()])
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

    public function create(AdminUserArgumentForCreate $adminUserArgumentForCreate): AdminUserDomain
    {
        $model = new AdminUserModel();
        $model->user_id = $adminUserArgumentForCreate->adminUserId->rawValue();
        $model->password = $adminUserArgumentForCreate->hashedPassword->rawValue();
        $model->name = $adminUserArgumentForCreate->name->rawValue();
        $model->role = $adminUserArgumentForCreate->role->rawValue();
        $model->status = $adminUserArgumentForCreate->status->rawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(
        AdminId        $id,
        AdminUserId    $userId,
        HashedPassword $password,
        PeopleName     $name,
        AdminUserRole  $role,
        AdminUserStatus $status
    ){
        $model = AdminUserModel::where('id', $id)->first();
        $model->user_id = $userId->rawValue();
        $model->password = $password->rawValue();
        $model->name = $name->rawValue();
        $model->role = $role->rawValue();
        $model->status = $status->rawValue();
        $model->save();
    }

    public function delete(AdminId $id)
    {
        $model = AdminUser::where('id', $id)->first();
        if (!$model) {
            throw new NotFoundException();
        }
        $model->delete();
    }
}
