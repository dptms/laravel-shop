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

// 首页
Route::get('/', 'PagesController@root')->name('root');

// 权限路由
Auth::routes();

// 需要登录的路由
Route::group(['middleware' => 'auth'], function () {
    // 邮箱验证
    Route::get('/email_verify_notice', 'PagesController@emailVerifyNotice')->name('email_verify_notice');

    // 邮箱验证通过的路由
    Route::group(['middleware' => 'email_verified'], function () {

    });
});

Route::get('test', function () {

})->name('app.test');