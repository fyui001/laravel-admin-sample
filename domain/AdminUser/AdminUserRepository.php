<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Illuminate\Pagination\LengthAwarePaginator;

interface AdminUserRepository
{
    public function get(AdminId $id): AdminUser;
    public function getPaginate(): LengthAwarePaginator;
    public function create(
        AdminUserId $adminUserId,
        AdminUserHashedPassword $password,
        AdminUserName $name,
        AdminUserRole $role,
        AdminUserStatus $status
    ): AdminUser;
    public function update(
        AdminId $id,
        AdminUserId $adminUserId,
        AdminUserHashedPassword $password,
        AdminUserName $name,
        AdminUserRole $role,
        AdminUserStatus $status
    ): AdminUser;
    public function delete(AdminId $id): bool;
}
