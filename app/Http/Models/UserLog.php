<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/10/24
 */
namespace App\Http\Models;

class UserLog extends BaseModel
{
    public static $table = 'bas_user_log';

    public static function saveLog($message, $userId = 0)
    {
        if (!$userId) $userId = session('user_id');

        $data = [
            'user_id' => $userId,
            'message' => $message,
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ];
        UserLog::save(self::$table, $data);
    }
}