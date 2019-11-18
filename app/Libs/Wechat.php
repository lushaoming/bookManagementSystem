<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/10/24
 */
namespace App\Libs;

class Wechat
{
    /**
     * @param $code
     * @return bool|mixed|string
     * @throws \Exception
     * @author 卢绍明<lusm@sz-bcs.com.cn>
     * @date   2019/10/24
     */
    public static function getAccessToken($code)
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.WECHAT_CONFIG['app_id'].
            '&secret='.WECHAT_CONFIG['app_secret'].'&code='.$code.'&grant_type=authorization_code';
        $res = ApiCore::curl($url);
        $res = json_decode($res, true);

        if (empty($res)) throw new \Exception('Get user access token failed');

        if (isset($res['errcode']) && $res['errcode']) {
            throw new \Exception($res['errmsg']);
        }

        return $res;
    }

    /**
     * @param $accessToken
     * @param $openid
     * @return bool|mixed|string
     * @throws \Exception
     * @author 卢绍明<lusm@sz-bcs.com.cn>
     * @date   2019/10/24
     */
    public static function getUserInfo($accessToken, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openid}&lang=zh_CN";
        $res = ApiCore::curl($url);
        $res = json_decode($res, true);

        if (empty($res)) throw new \Exception('Get user information failed');

        if (isset($res['errcode']) && $res['errcode']) {
            throw new \Exception($res['errmsg']);
        }

        return $res;
    }
}