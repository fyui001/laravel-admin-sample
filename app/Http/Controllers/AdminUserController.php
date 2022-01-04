<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use App\Services\Interfaces\AdminUserServiceInterface;
use App\Http\Requests\AdminUsers\CreateAdminUserRequest;
use App\Http\Requests\AdminUsers\UpdateAdminUserRequest;
use Domain\AdminUser\AdminId;
use Infra\EloquentModels\AdminUser;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends AppController
{

    protected AdminUserServiceInterface $adminUserService;

    public function __construct(AdminUserServiceInterface $adminUserService)
    {
        parent::__construct();
        $this->adminUserService = $adminUserService;
    }

    /**
     * Index of users.
     *
     * @return View
     */
    public function index(): View
    {
        $adminUsers = $this->adminUserService->getAdminUserPaginator();
        return view('admin_users.index', compact('adminUsers'));
    }

    /**
     * Form to create user.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin_users.create');
    }

    /**
     * Store a user.
     *
     * @param CreateAdminUserRequest $request
     * @return RedirectResponse
     */
    public function store(CreateAdminUserRequest $request): RedirectResponse
    {
        $this->adminUserService->createUser($request);
        return redirect(route('admin_users.index'))
                ->with('success', 'ユーザーを保存しました');
    }

    /**
     * Form to update the user.
     *
     * @param AdminUser $adminUser
     * @return View
     */
    public function edit(AdminUser $adminUser): View
    {
        return view('admin_users.edit', compact('adminUser'));
    }

    /**
     * Update the user.
     *
     * @param string $id
     * @param UpdateAdminUserRequest $request
     * @return RedirectResponse
     */
    public function update(string $id, UpdateAdminUserRequest $request): RedirectResponse
    {
        $this->adminUserService->updateUser(
            new AdminId((int)$id),
            $request
        );
        return redirect(route('admin_users.index'))->with([
            'success' => 'ユーザーを編集しました'
        ]);
    }

    /**
     * Delete the user.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->adminUserService->deleteUser(
            new AdminId((int)$id)
        );
        return redirect()->route('admin_users.index')->with([
            'success' => 'ユーザーを削除しました'
        ]);
    }

}
