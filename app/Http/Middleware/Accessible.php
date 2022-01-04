<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Domain\AdminUser\AdminUserRole;
use Closure;
use Illuminate\Support\Str;

class Accessible
{

    public function handle($request, Closure $next, $guards = null) {
        $currentUser = \Auth::user();

        // Current route is not one of avaiable routes
        if ($currentUser) {
            $accessibleRoutes = $this->getAccessibleRoutes($currentUser->role);
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
    protected function getAccessibleRoutes(int $roleId): array {

        $routes = [
            AdminUserRole::ROLE_SYSTEM => [
                'auth.*',
                'admin_users.*',
                'news.*',
                'top_page',
            ],
            AdminUserRole::ROLE_ADMIN => [
                'auth.*',
                'news.*',
                'top_page',
            ],
            AdminUserRole::ROLE_USER => [
                'auth.*',
                'news.index',
                'top_page',
            ]
        ];

        return data_get($routes, $roleId, []);

    }

    /**
     *
     *
     * @param array $avaiableRoutes
     * @return bool
     */
    protected function containsCurrentRoute(array $avaiableRoutes): bool {

        $currentRoute = \Route::currentRouteName();

        foreach ($avaiableRoutes as $route) {
            if (Str::is($route, $currentRoute)) {
                return true;
            }
        }

        return false;
    }

}
