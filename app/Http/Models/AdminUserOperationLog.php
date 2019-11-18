<?php
/**
 * Class AdminUserOperationLog
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/16
 */
namespace App\Http\Models;

class AdminUserOperationLog extends BaseModel
{
    public static $table = 'bas_admin_user_operation_log';

    public static function saveLog($userId, $message)
    {
        $save = [
            'admin_id' => $userId,
            'message' => $message
        ];
        self::save(self::$table, $save);
    }
}