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
Route::get('/admins/admin/add','Admins\Admin@add');
Route::get('/admins/admin/save','Admins\Admin@save');
Route::get('/admins/admin/del','Admins\Admin@del');

// 后台相关
Route::namespace('admins')->middleware(['auth','rights'])->group(function(){
    Route::get('/admins/home/index','Home@index');
    // 管理员相关路由
    Route::get('/admins/admin/index','Admin@index');
    Route::get('/admins/home/welcome','Home@welcome');
    // 系统设置相关
    Route::get('/admins/setting/index','Setting@index');
});