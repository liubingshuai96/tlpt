<?php
/**
 * 后台接口
 */

Route::post('admin_login','Admin\LoginController@admin_login');     //管理员登录
Route::post('captcha','Admin\LoginController@captcha');  //验证码

Route::post('admin_quit','Admin\LoginController@admin_quit'); //退出登录
