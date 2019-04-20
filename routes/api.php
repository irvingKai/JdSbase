<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::prefix('v1')->group(function () {
//
//    Route::prefix('auth')->namespace('Auth')->group(function($router) {
//        $router->post('login', 'AuthController@login');
//        // 刷新token
//        $router->post('refresh/token', 'AuthController@refresh');
//
//    });
//
//    Route::middleware('auth.jwt')->group(function($router) {
//
//        $router->namespace('Auth')->group(function ($router) {
//            // 退出登录
//            $router->post('logout', 'AuthController@logout');
//        });
//
//        /*
//        |----------------------------------------------------------------------
//        | 权限管理
//        |----------------------------------------------------------------------
//        |
//        |
//        */
//        Route::prefix('permission')->group(function ($router) {
//            $router->post('/', 'PermissionController@index');
//            // 我的权限
//            $router->post('my/roles', 'PermissionController@myRoles');
//        });
//
//
//
//
//
//        $router->post('test','ManagerController@index');
//    });
//});


