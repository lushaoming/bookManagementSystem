<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/7
 */
namespace App\Http\Models;

class AdminUserLoginLog extends BaseModel
{
    public static $table = 'bas_admin_user_login_log';

    public static function saveLog($adminId, $status = 1)
    {
        self::save(self::$table, ['admin_id' => $adminId, 'status' => $status, 'ip_address' => $_SERVER['REMOTE_ADDR']]);
    }

}