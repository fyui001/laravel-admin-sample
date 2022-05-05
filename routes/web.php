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
    /* Top Page */
    Route::get('/top', 'HomeController@index')->name('admin.top_page');

    /* Auth */
    Route::prefix('auth')->group(function () {
        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('admin.auth.login');
        Route::post('/login', 'Auth\LoginController@login')->name('admin.auth.login.post');
        Route::get('/logout', 'Auth\LoginController@logout')->name('admin.auth.logout');
    });

    /* AdminUsers */
    Route::prefix('admin_users')->group(function() {
        Route::get('/','AdminUserController@index')->name('admin.admin_users.index');
        Route::get('/create','AdminUserController@create')->name('admin.admin_users.create');
        Route::post('/','AdminUserController@store')->name('admin.admin_users.store');
        Route::get('/{adminUser}/edit','AdminUserController@edit')->where('user', '[0-9]+')->name('admin.admin_users.edit');
        Route::put('/{adminUser}','AdminUserController@update')->where('user', '[0-9]+')->name('admin.admin_users.update');
        Route::delete('/{adminUser}','AdminUserController@destroy')->where('user', '[0-9]+')->name('admin.admin_users.destroy');
    });

    /* News */
    Route::prefix('news')->group(function() {
        Route::get('/', 'NewsController@index')->name('admin.news.index');
        Route::get('/create', 'NewsController@create')->name('admin.news.create');
        Route::post('/', 'NewsController@store')->name('admin.news.store');
        Route::put('/{news}', 'NewsController@update')->where('news', '[0-9]+')->name('admin.news.update');
        Route::get('/{news}/edit', 'NewsController@edit')->where('news', '[0-9]+')->name('admin.news.edit');
        Route::delete('/{news}', 'NewsController@destroy')->where('news', '[0-9]+')->name('admin.news.destroy');
    });
});
