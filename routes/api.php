<?php

/*
 * style: fix StyleCI.
 */

use Illuminate\Support\Facades\Route;

// 初始化数据
Route::get('source', 'DataSourceController');

Route::post('login', 'LoginController@login')->name('login');
Route::post('logout', 'LoginCOntroller@logout')->name('logout');
