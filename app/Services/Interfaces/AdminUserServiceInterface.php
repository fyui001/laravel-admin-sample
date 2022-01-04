<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Domain\AdminUser\AdminId;
use App\Http\Requests\AdminUsers\UpdateAdminUserRequest;
use App\Http\Requests\AdminUsers\CreateAdminUserRequest;
use Illuminate\Pagination\LengthAwarePaginator;

interface AdminUserServiceInterface
{
    public function getAdminUserPaginator(): LengthAwarePaginator;
    public function createUser(CreateAdminUserRequest $request);
    public function updateUser(AdminId $id, UpdateAdminUserRequest $request);
    public function deleteUser(AdminId $id);
}
