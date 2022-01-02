<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\AdminUser\AdminUserRepositoryArgument\AdminUserArgumentForCreate;
use Domain\Common\HashedPassword;
use Domain\Common\PeopleName;
use Domain\Common\UserRole;
use Domain\Common\UserStatus;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminUserDomainService
{
    private AdminUserRepository $repository;

    public function __construct(
        AdminUserRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function getAdminUserPaginator(): LengthAwarePaginator
    {
        return $this->repository->getPaginate();
    }

    public function create(AdminUserArgumentForCreate $adminUserArgumentForCreate)
    {
        $this->repository->create($adminUserArgumentForCreate);
    }

    public function update(
        AdminId $id,
        AdminUserId $userId,
        HashedPassword $password,
        PeopleName $name,
        UserRole $role,
        UserStatus $status
    ){
        $this->repository->update(
            $id,
            $userId,
            $password,
            $name,
            $role,
            $status
        );
    }

    public function delete(AdminId $id)
    {
        $this->repository->delete($id);
    }
}
