<?php

use Illuminate\Support\Facades\Route;

// 初始化数据.
Route::get('source', 'DataSourceController');

// 登录退出.
Route::post('login', 'LoginController@login')->name('login');
Route::post('logout', 'LoginCOntroller@logout')->name('logout');

// 更新基本信息.
Route::post('personal/account', 'PersonalController@account');
Route::post('personal/avatar', 'PersonalController@avatar');

Route::group(['middleware' => ['login:admin', 'authorize']], function () {
    Route::apiResources([
        'role' => 'RoleController',
    ]);
});
