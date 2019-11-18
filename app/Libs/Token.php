<?php
/**
 * Class Token
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/07
 */
namespace App\Libs;

use Firebase\JWT\JWT;

class Token
{
    public static function create($token, $expire = 7200)
    {
        $server = $_SERVER['SERVER_NAME'];
        $token['iss'] = $server;
        $token['sub'] = $server;
        $token['aud'] = $server;
        $token['iat'] = time();
        $token['exp'] = time() + $expire;
        try {
            return JWT::encode($token, KEY_SALT, 'RS256');
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function decode($token)
    {
        try {
            return JWT::decode($token, KEY_SALT, array('RS256'));
        } catch (\Exception $e) {
            return false;
        }
    }
}