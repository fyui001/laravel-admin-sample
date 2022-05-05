<?php

declare(strict_types=1);

namespace Domain\AdminUser;

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

    public function create(
        AdminUserId $adminUserId,
        AdminUserHashedPassword $password,
        AdminUserName $name,
        AdminUserRole $role,
        AdminUSerStatus $status
    ): AdminUser {
        return $this->repository->create(
            $adminUserId,
            $password,
            $name,
            $role,
            $status
        );
    }

    public function update(
        AdminId $id,
        AdminUserId $userId,
        AdminUserHashedPassword $password,
        AdminUserName $name,
        AdminUserRole $role,
        AdminUserStatus $status
    ): AdminUser {
        return $this->repository->update(
            $id,
            $userId,
            $password,
            $name,
            $role,
            $status
        );
    }

    public function delete(AdminId $id): bool
    {
        return $this->repository->delete($id);
    }
}
