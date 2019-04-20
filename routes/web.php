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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('v1')->group(function () {

    Route::prefix('auth')->namespace('Auth')->group(function($router) {
        $router->post('login', 'AuthController@login');
        $router->post('sign', 'RegisterController@create');
        // 刷新token
        $router->post('refresh/token', 'AuthController@refresh');

    });

    Route::middleware('auth.jwt')->group(function($router) {

        $router->namespace('Auth')->group(function ($router) {
            // 退出登录
            $router->post('logout', 'AuthController@logout');
        });

        /*
        |----------------------------------------------------------------------
        | 权限管理
        |----------------------------------------------------------------------
        |
        |
        */
        Route::prefix('permission')->group(function ($router) {
            $router->post('/', 'PermissionController@index');
            // 我的权限
            $router->post('my/roles', 'PermissionController@myRoles');
        });

        /*
        |----------------------------------------------------------------------
        | 用户管理
        |----------------------------------------------------------------------
        |
        |
        */
        Route::prefix('user')->group(function ($router) {
            $router->post('info', 'UserController@userInfo');
            // 我的权限
            $router->post('my/roles', 'PermissionController@myRoles');
        });
    });
});