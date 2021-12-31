<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Infra\EloquentModels\AdminUser;
use App\Http\Requests\Request;
use App\Http\Requests\AdminUsers\CreateAdminUserRequest;
use Illuminate\Pagination\LengthAwarePaginator;

interface AdminUserServiceInterface
{
    public function getUsers(): LengthAwarePaginator;
    public function createUser(CreateAdminUserRequest $request): AdminUser;
    public function updateUser(AdminUser $user, Request $request);
    public function deleteUser(AdminUser $user);
}
