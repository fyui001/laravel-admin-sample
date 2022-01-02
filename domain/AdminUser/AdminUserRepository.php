<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\AdminUser\AdminUserRepositoryArgument\AdminUserArgumentForCreate;
use Domain\Common\HashedPassword;
use Domain\Common\PeopleName;
use Domain\Common\UserRole;
use Domain\Common\UserStatus;
use Illuminate\Pagination\LengthAwarePaginator;

interface AdminUserRepository
{
    public function get(AdminId $id): AdminUser;
    public function getPaginate(): LengthAwarePaginator;
    public function create(AdminUserArgumentForCreate $adminUserArgumentForCreate);
    public function update(AdminId $id,
                           AdminUserId $userId,
                           HashedPassword $password,
                           PeopleName $name,
                           UserRole $role,
                           UserStatus $status
    );
    public function delete(AdminId $id);
}
