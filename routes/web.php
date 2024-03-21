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

Route::redirect('/', '/admin/auth/login');

Route::group(['prefix' => 'admin'], function() {

    /* Auth */
    Route::prefix('auth')->group(function () {
        Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.auth.login');
        Route::post('/login', 'Admin\Auth\LoginController@login')->name('admin.auth.login.post');
        Route::post('/logout', 'Admin\Auth\LoginController@logout')->name('admin.auth.logout');
    });

    Route::group(['middleware' => 'auth:web'], function() {
        /* Top Page */
        Route::get('/top', 'Admin\HomeController@index')->name('admin.top_page');

        /* AdminUsers */
        Route::prefix('admin_users')->group(function() {
            Route::get('/','Admin\AdminUserController@index')->name('admin.admin_users.index');
            Route::get('/create','Admin\AdminUserController@create')->name('admin.admin_users.create');
            Route::post('/','Admin\AdminUserController@store')->name('admin.admin_users.store');
            Route::get('/{adminUser}/edit','Admin\AdminUserController@edit')->where('user', '[0-9]+')->name('admin.admin_users.edit');
            Route::put('/{adminUser}','Admin\AdminUserController@update')->where('user', '[0-9]+')->name('admin.admin_users.update');
            Route::delete('/{adminUser}','Admin\AdminUserController@destroy')->where('user', '[0-9]+')->name('admin.admin_users.destroy');
        });

        /* News */
        Route::prefix('news')->group(function() {
            Route::get('/', 'Admin\NewsController@index')->name('admin.news.index');
            Route::get('/create', 'Admin\NewsController@create')->name('admin.news.create');
            Route::post('/', 'Admin\NewsController@store')->name('admin.news.store');
            Route::put('/{news}', 'Admin\NewsController@update')->where('news', '[0-9]+')->name('admin.news.update');
            Route::get('/{news}/edit', 'Admin\NewsController@edit')->where('news', '[0-9]+')->name('admin.news.edit');
            Route::delete('/{news}', 'Admin\NewsController@destroy')->where('news', '[0-9]+')->name('admin.news.destroy');
        });
    });
});
