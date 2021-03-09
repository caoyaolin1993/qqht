<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admins/account/login','Admins\Account@login')->name('login');
Route::get('/admins/account/captcha','Admins\Account@captcha');
Route::post('/admins/account/dologin','Admins\Account@dologin');

Route::get('/admins/account/logout','Admins\Account@logout');

Route::get('/admins/admin/indexdata','Admins\Admin@indexdata');

Route::get('/admins/admin/save','Admins\Admin@save');

// 后台相关
Route::namespace('admins')->middleware(['auth','rights'])->group(function(){
    Route::get('/admins/home/index','Home@index');
    // 管理员相关路由
    Route::get('/admins/admin/index','Admin@index');
    Route::get('/admins/home/welcome','Home@welcome');
    Route::get('/admins/admin/edit','Admin@edit');
    Route::post('/admins/admin/edit','Admin@edit');
    Route::get('/admins/admin/del','Admin@del');
    Route::get('/admins/admin/detail','Admin@detail');
    Route::get('/admins/admin/add','Admin@add');
    Route::post('/admins/admin/add','Admin@add');
    Route::get('/admins/admin/upstatus','Admin@upstatus');
    // 菜单相关
    Route::get('/admins/menus/index','Menus@index');
    Route::get('/admins/menus/indexdata','Menus@indexdata');
});
