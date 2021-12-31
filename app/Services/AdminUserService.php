<?php

declare(strict_types=1);

namespace App\Services;

use Infra\EloquentModels\AdminUser;
use App\Services\Service as BaseService;
use App\Http\Requests\Request;
use App\Services\Interfaces\AdminUserServiceInterface;
use App\Http\Requests\AdminUsers\CreateAdminUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class AdminUserService extends BaseService implements AdminUserServiceInterface
{

    /**
     * Get all users.
     *
     * @return LengthAwarePaginator
     */
    public function getUsers(): LengthAwarePaginator
    {
        return AdminUser::paginate(15);
    }

    /**
     * Create a user.
     *
     * @param CreateAdminUserRequest $request
     * @return AdminUser
     * @throws Exception
     */
    public function createUser(CreateAdminUserRequest $request): AdminUser
    {

        $result = AdminUser::create([
            'user_id' => $request->get('user_id'),
            'password' => Hash::make($request->get('password')),
            'name' => $request->get('name'),
            'role' => $request->get('role', ''),
            'status' => $request->get('status', ''),
        ]);
        if (empty($result)) {
            throw new Exception('Failed to create');
        }
        return $result;
    }

    /**
     * Update the user.
     *
     * @param AdminUser $adminUser
     * @param Request $request
     */
    public function updateUser(AdminUser $adminUser, Request $request)
    {

        $data = [
            'user_id' => $request->get('user_id'),
            'name' => $request->get('name'),
            'role' => $request->get('role', ''),
            'status' => $request->get('status', ''),
        ];
        if (!empty($request->get('password'))) {
            $data['password'] = Hash::make($request->get('password'));
        }
        if (!$adminUser->update($data)) {
            throw new Exception('Failed to update');
        }
    }

    /**
     * Delete the user.
     *
     * @param AdminUser $adminUser
     */
    public function deleteUser(AdminUser $adminUser)
    {

        if (!$adminUser->delete()) {
            throw new Exception('Failed to delete');
        }
    }
}
