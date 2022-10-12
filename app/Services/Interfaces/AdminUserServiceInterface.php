<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserList;
use Domain\AdminUser\AdminUserName;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use Domain\Common\RawPassword;

interface AdminUserServiceInterface
{
    public function getAdminUserPaginator(): AdminUserList;
    public function createUser(
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    );
    public function updateUser(
        AdminId $id,
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    );
    public function deleteUser(AdminId $id);
}
