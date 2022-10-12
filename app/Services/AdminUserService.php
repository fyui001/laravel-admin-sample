<?php

declare(strict_types=1);

namespace App\Services;

use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserList;
use Domain\AdminUser\AdminUserName;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use App\Services\Service as BaseService;
use App\Services\Interfaces\AdminUserServiceInterface;
use Domain\AdminUser\AdminUserDomainService;
use Domain\Common\RawPassword;

class AdminUserService extends BaseService implements AdminUserServiceInterface
{
    protected AdminUserDomainService $adminUserDomainService;

    public function __construct(AdminUserDomainService $adminUserDomainService)
    {
        $this->adminUserDomainService = $adminUserDomainService;
    }

    /**
     * Get all user paginator.
     *
     * @return AdminUserList
     */
    public function getAdminUserPaginator(): AdminUserList
    {
        return $this->adminUserDomainService->getAdminUserList();
    }

    /**
     * Create a user.
     *
     * @param AdminUserId $adminUserId
     * @param RawPassword $adminUserRawPassWord
     * @param AdminUserName $adminUserName
     * @param AdminUserRole $adminUserRole
     * @param AdminUserStatus $adminUserStatus
     */
    public function createUser(
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    ): void {
        $this->adminUserDomainService->createAdminUser(
            $adminUserId,
            $adminUserRawPassWord,
            $adminUserName,
            $adminUserRole,
            $adminUserStatus,
        );
    }

    /**
     * Update the user.
     *
     * @param AdminId $id
     * @param AdminUserId $adminUserId
     * @param RawPassword $adminUserRawPassWord
     * @param AdminUserName $adminUserName
     * @param AdminUserRole $adminUserRole
     * @param AdminUserStatus $adminUserStatus
     */
    public function updateUser(
        AdminId $id,
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    ): void {
        $this->adminUserDomainService->updateAdminUser(
            $id,
            $adminUserId,
            $adminUserRawPassWord,
            $adminUserName,
            $adminUserRole,
            $adminUserStatus,
        );
    }

    /**
     * Delete the user.
     *
     * @param AdminId $id
     */
    public function deleteUser(AdminId $id): void
    {
        $this->adminUserDomainService->deleteAdminUser($id);
    }
}
