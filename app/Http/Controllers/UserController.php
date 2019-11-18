<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/10/24
 */
namespace App\Http\Controllers;

use App\Http\Models\User;
use const App\Libs\LOGIN_TYPE;
use const App\Libs\USER_CAN_REGISTER;
use const App\Libs\WECHAT_CONFIG;

class UserController extends BaseController
{
    public function login()
    {
        // 微信授权登录
        if (LOGIN_TYPE == 'wechat') {
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . WECHAT_CONFIG['app_id'] .
                '&redirect_uri=' . WECHAT_CONFIG['redirect_uri'] . '&response_type=code&scope=snsapi_userinfo&state=test#wechat_redirect';
            return redirect($url);
        }

        return view('user.login');
    }

    public function register()
    {
        // 不可注册
        if (LOGIN_TYPE != 'account' || !USER_CAN_REGISTER) {
            return redirect('/login');
        }
        return view('user.register');

    }

    public function index()
    {
        echo '<img src="'.session('avatar').'">';exit;
        return view('user.index');
    }
}