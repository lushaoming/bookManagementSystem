<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/10/24
 */
namespace App\Http\Controllers;

use App\Http\Models\User;
use App\Libs\ApiCore;
use App\Libs\Logger;
use App\Libs\Wechat;

class WechatController extends BaseController
{
    public function oauthCallback()
    {
        $code = ApiCore::getNotEmptyVar('code', 'Empty code');
        $state = ApiCore::getVar('state', '');

        try {
            $accessToken = Wechat::getAccessToken($code);

            $userInfo = Wechat::getUserInfo($accessToken['access_token'], $accessToken['openid']);

//            $userInfo = [
//                'openid' => 'oLLbN5qdDXvOQZY1vGvrcf7J67bE',
//                'nickname' => '幽忧子L',
//                'sex' => 1,
//                'language' => 'zh_CN',
//                'city' => '广州',
//                'province' => '广东',
//                'country' => '中国',
//                'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/znK4S9gchlSN7bazZw6oWmv5Eax3TVMh6TeS1Xj2UHZpveM1CJJXU86j5biaOejrzJnhtdmhyFUWXkM0sG8SlGg/132'
//            ];
            $userId = User::saveUser($userInfo, 2);

            session([
                'user_id' => $userId,
                'nickname' => $userInfo['nickname'],
                'avatar' => $userInfo['headimgurl']
            ]);

            return redirect('user/index');

        } catch (\Exception $e) {
            Logger::save($e);
            exit('Sorry, an unexpected error has occurred.');
        }

    }
}