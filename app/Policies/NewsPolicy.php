<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use Infra\EloquentModels\AdminUser;

class NewsPolicy
{

    /**
     * Determine if the current user can create news
     *
     * @param AdminUser $adminUser
     * @return Response
     */
    public function create(AdminUser $adminUser): Response
    {
        $adminUserDomain = $adminUser->toDomain();

        return $adminUserDomain->getRole()->isSystem()
            ? Response::allow()
            : Response::deny('You do not own system role.');
    }

    /**
     * Determine if the current user can update news
     *
     * @param AdminUser $adminUser
     * @return Response
     */
    public function update(AdminUser $adminUser): Response
    {
        $adminUserDomain = $adminUser->toDomain();

        return $adminUserDomain->getRole()->isSystem()
            ? Response::allow()
            : Response::deny('You do not own system role.');
    }
}
