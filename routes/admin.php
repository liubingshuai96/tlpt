<?php
/**
 * 后台接口
 */

Route::post('admin_login','Admin\LoginController@admin_login');     //管理员登录
Route::get('captcha/{tmp}','Admin\LoginController@captcha');  //验证码
Route::post('admin_quit','Admin\LoginController@admin_quit'); //退出登录
//用户
Route::post('user/user_mange','Admin\UserController@user_mange'); //用户管理页面

//管理员
Route::post('admin/admin_list','Admin\SysAdminController@admin_list'); //管理员列表
Route::post('admin/add_admin','Admin\SysAdminController@add_admin'); //添加管理员
