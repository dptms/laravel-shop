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
Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');
Route::get('products/{product}', 'ProductsController@show')->name('products.show');
// 权限路由
Auth::routes();

// 需要登录的路由
Route::group(['middleware' => 'auth'], function () {
    // 发送验证邮件
    Route::get('/email_verification/send', 'EmailVerificationController@send')->name('email_verification.send');
    // 邮箱验证提示
    Route::get('/email_verify_notice', 'PagesController@emailVerifyNotice')->name('email_verify_notice');
    // 邮箱验证
    Route::get('/email_verify_notice/verify', 'EmailVerificationController@verify')->name('email_verify_notice.verify');
    // 邮箱验证通过的路由
    Route::group(['middleware' => 'email_verified'], function () {
        // 用户收货地址列表
        Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
        // 用户添加收货地址页面
        Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
        // 用户添加收货地址
        Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
        // 用户修改收货地址页面
        Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
        // 用户修改收货地址
        Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
        // 用户删除收货地址
        Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');
    });
});

Route::get('test', function () {
})->name('app.test');