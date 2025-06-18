<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\AdminUser;
use Closure;
use Domain\AdminUser\AdminUserRole;
use Illuminate\Support\Str;

class Accessible
{
    public function handle($request, Closure $next, $guards = null)
    {
        /** @var AdminUser $currentUser */
        $currentUser = \Auth::user();

        // Current route is not one of available routes
        if ($currentUser) {
            $accessibleRoutes = $this->getAccessibleRoutes(
                $currentUser->getAdminUser()->getRole()->getValue()->getRawValue()
            );

            abort_unless($this->containsCurrentRoute($accessibleRoutes), 403);
        }

        return $next($request);
    }

    /**
     *
     *
     * @param int $roleId
     * @return array
     */
    protected function getAccessibleRoutes(string $roleId): array
    {

        $routes = [
            AdminUserRole::SYSTEM->getValue()->getRawValue() => [
                'admin.auth.*',
                'admin.admin_users.*',
                'admin.top_page',
                'admin.news.*',
                'admin.release_flags.*',
            ],
            AdminUserRole::ADMIN->getValue()->getRawValue() => [
                'admin.auth.*',
                'admin.top_page',
                'admin.news.*',
            ],
            AdminUserRole::OPERATOR->getValue()->getRawValue() => [
                'admin.auth.*',
                'admin.top_page',
                'admin.news.index',
            ],
            AdminUserRole::NONE->getValue()->getRawValue() => [
                'admin.auth.*',
                'admin.top_page',
            ]
        ];

        return data_get($routes, $roleId, []);
    }

    /**
     *
     *
     * @param array $availableRoutes
     * @return bool
     */
    protected function containsCurrentRoute(array $availableRoutes): bool
    {
        $currentRoute = \Route::currentRouteName();

        foreach ($availableRoutes as $route) {
            if (Str::is($route, $currentRoute)) {
                return true;
            }
        }

        return false;
    }
}
