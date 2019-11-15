<?php
/**
 * @后台接口
 * @datetime 2019-11-4
 * @author liu
 */

//登录
Route::post('admin_login','Admin\LoginController@admin_login');   //管理员登录
Route::post('admin_quit','Admin\LoginController@admin_quit'); //退出登录
//用户
Route::post('user/user_mange','Admin\UserController@user_mange'); //用户管理页面

//管理员
Route::post('admin/admin_list','Admin\SysAdminController@admin_list'); //管理员列表
Route::post('admin/add_admin','Admin\SysAdminController@add_admin'); //添加管理员
Route::post('admin/edit_admin','Admin\SysAdminController@edit_admin'); //修改管理员
Route::post('admin/del_admin','Admin\SysAdminController@del_admin'); //删除管理员

//权限组管理
Route::post('admin/permission_group','Admin\AdminGroupController@permission_group'); //权限组管理
Route::post('admin/add_permission_group','Admin\AdminGroupController@add_permission_group'); //添加权限组管理
Route::post('admin/edit_admin_group','Admin\AdminGroupController@edit_admin_group'); //修改权限组管理
Route::post('admin/del_admin_group','Admin\AdminGroupController@del_admin_group'); //删除权限组管理
Route::post('admin/menu_column','Admin\AdminGroupController@menu_column');      //菜单栏目

//角色管理
Route::post('admin/role_list','Admin\AdminRoleController@role_list');    //角色列表
Route::post('admin/add_role','Admin\AdminRoleController@add_role');    //添加角色
Route::post('admin/edit_role','Admin\AdminRoleController@edit_role');    //修改角色
Route::post('admin/del_role','Admin\AdminRoleController@del_role');    //删除角色

//药材管理
Route::post('medicine/medicine_list','Admin\MedicineController@medicine_list'); //药材列表
Route::post('medicine/add_medicine','Admin\MedicineController@add_medicine');  //添加药材
Route::post('medicine/edit_medicine','Admin\MedicineController@edit_medicine'); //修改药材
Route::post('medicine/del_medicine','Admin\MedicineController@del_medicine');  //删除药材
