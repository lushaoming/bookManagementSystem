<?php
/**
 * 后台管理路由
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/5
 */
Route::middleware('authorization')->group(function () {
    Route::get('/', 'Admin\WelcomeController@index');

    Route::get('/welcome', function (){
        return view('admin.welcome');
    });
    // 首页统计信息
    Route::get('/index/statistics', 'Admin\IndexController@getStatistics');

    // 图书列表
    Route::get('/book', 'Admin\BookController@index');
    Route::post('/book', 'Admin\BookController@add');

    Route::get('/book/add', 'Admin\BookController@add');
});

Route::middleware('noAuthorization')->group(function () {
    // 通用ajax请求接口
    Route::any('/ajax', 'Admin\AjaxController@index');
    // 登录
    Route::any('/login', 'Admin\AdminUserController@login');
    // 登出
    Route::get('/logout', 'Admin\AdminUserController@logout');
    // 获取系统设置
    Route::any('/system/setting', 'Admin\SystemController@systemSetting');
    // 获取图书分类
    Route::get('/categories', 'Admin\CategoryController@index');
});


