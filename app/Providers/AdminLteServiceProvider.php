<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Http\ViewComposers\AdminLteComposer;

class AdminLteServiceProvider extends ServiceProvider
{
    public function boot(Factory $factory): void
    {
        $factory->composer('vendor.adminlte.page', AdminLteComposer::class);
    }
}
