<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/9/25
 */
namespace App\Libs;

class ApiCore
{
    public static $returnCode = [
        'SUCCESS' => ['code' => 0, 'msg' => 'SUCCESS'],
        'FAILURE' => ['code' => 400, 'msg' => 'Failure'],
        'REQUEST_INVALID' => ['code' => 10030, 'msg' => 'Request parameters are invalid'],
        'PERMISSION_DENY' => ['code' => 10031, 'msg' => 'Permission denied'],
        'APP_NOT_FOUND' => ['code' => 10032, 'msg' => 'App not found'],
        'SIGN_ERROR' => ['code' => 10033, 'msg' => 'Signature error'],
        'VERIFY_CODE_ERROR' => ['code' => 10034, 'msg' => 'Verification code error'],
        'REQUEST_TIMED_OUT' => ['code' => 10035, 'msg' => 'Request has timed out'],
        'INTERNAL_ERROR' => ['code' => 10036, 'msg' => 'Internal error'],
        'NOT_LOGIN' => ['code' => 10037, 'msg' => 'Please log in first'],
        'HAS_LOGIN' => ['code' => 10038, 'msg' => 'You have logged in'],
    ];

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public static function ajaxReturn($return = [], $data = [])
    {
        if (empty($return)) $return = self::$returnCode['SUCCESS'];

        $ret = [
            'code' => $return['code'],
            'msg' => $return['msg'],
            'data' => $data
        ];
        return json_encode($ret);
    }

    /**
     * curl操作
     * @param string $url    地址
     * @param bool   $isPost 是否post
     * @param array  $params post参数
     * @return bool|string
     */
    public static function curl($url, $isPost = false, $params = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($isPost === true) {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public static function getNotEmptyVar($key, $msg = 'Missing required parameters')
    {
        if (empty(request()->input($key))) exit(ApiCore::ajaxReturn(['code' => 400, 'msg' => $msg]));

        return request()->input($key);
    }

    public static function getVar($key, $default = '')
    {
        return request()->input($key, $default);
    }
}