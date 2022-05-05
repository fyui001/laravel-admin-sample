<?php

declare(strict_types=1);

namespace App\Services;

use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use App\Services\Service as BaseService;
use App\Http\Requests\AdminUsers\UpdateAdminUserRequest;
use App\Services\Interfaces\AdminUserServiceInterface;
use App\Http\Requests\AdminUsers\CreateAdminUserRequest;
use Domain\AdminUser\AdminUserDomainService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @return LengthAwarePaginator
     */
    public function getAdminUserPaginator(): LengthAwarePaginator
    {
        return $this->adminUserDomainService->getAdminUserPaginator();
    }

    /**
     * Create a user.
     *
     * @param CreateAdminUserRequest $request
     */
    public function createUser(CreateAdminUserRequest $request): void
    {
        $this->adminUserDomainService->create(
            $request->getAdminUserId(),
            $request->getPassword(),
            $request->getName(),
            $request->getRole(),
            $request->getStatus()
        );
    }

    /**
     * Update the user.
     *
     * @param AdminId $id
     * @param UpdateAdminUserRequest $request
     */
    public function updateUser(AdminId $id, UpdateAdminUserRequest $request): void
    {
        $this->adminUserDomainService->update(
            $id,
            $request->getAdminUserId(),
            $request->getPassword(),
            $request->getName(),
            $request->getRole(),
            $request->getStatus()
        );
    }

    /**
     * Delete the user.
     *
     * @param AdminId $id
     */
    public function deleteUser(AdminId $id)
    {
        $this->adminUserDomainService->delete($id);
    }
}
