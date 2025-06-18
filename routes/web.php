<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ReleaseFlagController;

Route::redirect('/', '/admin/auth/login');

Route::group(['prefix' => 'admin'], function() {

    /* Auth */
    Route::prefix('auth')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.auth.login');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.auth.login.post');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.auth.logout');
    });

    Route::group(['middleware' => 'auth:web'], function() {
        /* Top Page */
        Route::get('/top', [HomeController::class, 'index'])->name('admin.top_page');

        /* AdminUsers */
        Route::prefix('admin_users')->group(function() {
            Route::get('/', [AdminUserController::class, 'index'])->name('admin.admin_users.index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('admin.admin_users.create');
            Route::post('/', [AdminUserController::class, 'store'])->name('admin.admin_users.store');
            Route::get('/{adminUser}/edit', [AdminUserController::class, 'edit'])->where('user', '[0-9]+')->name('admin.admin_users.edit');
            Route::put('/{adminUser}', [AdminUserController::class, 'update'])->where('user', '[0-9]+')->name('admin.admin_users.update');
            Route::delete('/{adminUser}', [AdminUserController::class, 'destroy'])->where('user', '[0-9]+')->name('admin.admin_users.destroy');
        });

        /* News */
        Route::prefix('news')->group(function() {
            Route::get('/', [NewsController::class, 'index'])->name('admin.news.index');
            Route::get('/create', [NewsController::class, 'create'])->name('admin.news.create');
            Route::post('/', [NewsController::class, 'store'])->name('admin.news.store');
            Route::put('/{news}', [NewsController::class, 'update'])->where('news', '[0-9]+')->name('admin.news.update');
            Route::get('/{news}/edit', [NewsController::class, 'edit'])->where('news', '[0-9]+')->name('admin.news.edit');
            Route::delete('/{news}', [NewsController::class, 'destroy'])->where('news', '[0-9]+')->name('admin.news.destroy');
        });

        /* ReleaseFlag */
        Route::prefix('release_flags')->group(function () {
            Route::get('/', [ReleaseFlagController::class, 'index'])->name('admin.release_flags.index');
            Route::get('/edit/{name}', [ReleaseFlagController::class, 'edit'])->name('admin.release_flags.edit');
            Route::post('/edit/{name}', [ReleaseFlagController::class, 'update'])->name('admin.release_flags.update');
        });
    });
});
