<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\AdminLte;

class AdminLteServiceProvider extends ServiceProvider
{
    public function boot(Factory $factory): void
    {
        $factory->composer('vendor.adminlte.page', function (View $view): void {
            $view->with('adminlte', $this->app->make(AdminLte::class));
        });
    }
}
