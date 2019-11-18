<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/10/24
 */
namespace App\Http\Models;

class User extends BaseModel
{
    public static $table = 'bas_user';
    private static $pwdKey = '4411def9d576984c8d78253236b2a62f';

    public static function saveUser($user, $type = 1)
    {
        if ($type == 1) {
            $data = [
                'username' => $user['username'],
                'password' => md5($user['password'] . self::$pwdKey),
                'nickname' => $user['nickname'],
                'update_time' => date('Y-m-d H:i:s')
            ];
            $userId = User::saveGetId(User::$table, $data);
        } else {
            $data = [
                'openid' => $user['openid'],
                'nickname' => $user['nickname'],
                'avatar' => $user['headimgurl'],
                'login_type' => $type,
                'country' => $user['country'],
                'province' => $user['province'],
                'city' => $user['city'],
                'gender' => $user['sex'],
                'update_time' => date('Y-m-d H:i:s')
            ];
            $where = ['openid' => $user['openid']];

            $userInfo = User::getSingleRow(self::$table, $where);
            if ($userInfo) {
                User::update(self::$table, $where, $data);
                $userId = $userInfo->id;
            } else {
                $userId = User::saveGetId(User::$table, $data);
            }
        }

        return $userId;
    }
}