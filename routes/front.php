<?php
/**
 * 前台路由
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/5
 */
Route::any('login', 'UserController@login');

Route::any('wechat/callback', 'WechatController@oauthCallback');

Route::get('user/index', 'UserController@index');