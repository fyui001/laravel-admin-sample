<?php

namespace App\Providers;

use Domain\AdminUser\AdminUserRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \Infra\EloquentRepository\AdminUserRepository::class => \App\Policies\AdminUserPolicy::class,
        \Infra\EloquentRepository\NewsRepository::class => \App\Policies\NewsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(AuthManager $authManager)
    {
        $this->registerPolicies();

        $authManager->provider('adminAuth', function ($app) {
            return new AdminUserProvider(
                $app->make(AdminUserRepository::class),
                $app['hash'],
            );
        });
    }
}
