<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/7
 */
namespace App\Http\Models;

use App\Libs\Redis;
use App\Libs\RedisService;
use Illuminate\Support\Facades\Session;

class AdminUser extends BaseModel
{
    public static $table = 'bas_admin_user';

    protected $error = '';

    public function login(string $username, string $password, bool $remember = false): int
    {
        $user = self::getSingleRow(self::$table, ['username' => $username]);

        if (!$user || $user->password != md5_password($password)) {
            if ($user) {
                AdminUserLoginLog::saveLog($user->id, 2);
                $failure = $this->getLoginFailTimes($user->login_failure);
                if ($failure >= get_config('safe.fail_login_limit')) {
                    $this->error = '当日达到最大登录失败次数，账号已被锁定，明天将自动恢复。';
                    return -2;
                }
                $update['login_failure'] = date('Y-m-d').':'.($failure+1);
                self::update(self::$table, ['id' => $user->id], $update);
            }
            $this->error = '账号或密码错误';
            return -1;
        }

        $failure = $this->getLoginFailTimes($user->login_failure);
        if ($failure >= get_config('safe.fail_login_limit')) {
            $this->error = '当日达到最大登录失败次数，账号已被锁定，明天将自动恢复。';
            return -2;
        }

        session([
            'admin_id' => $user->id,
            'admin_username' => $user->username,
            'admin_nickname' => $user->nickname,
        ]);
        AdminUserLoginLog::saveLog($user->id, 1);
        $this->userLoginSucceed($user->id, Session::getId());
        return $user->id;
    }

    public function getLoginFailTimes($userFailures)
    {
        $failure = explode(':', $userFailures);
        if (count($failure) != 2 || $failure[0] != date('Y-m-d')) {
            $times = 0;
        } else {
            $times = $failure[1];
        }
        return $times;
    }

    public function userLoginSucceed($userId, $sessionId)
    {
        self::update(self::$table, ['id' => $userId], ['login_failure' => '', 'session_id' => $sessionId, 'last_login_time' => date('Y-m-d H:i:s')]);
        $this->deleteUserSessionIdCache($userId);
    }

    public static function getLastSessionId($userId)
    {
        $sessionId = RedisService::get("sessionId:{$userId}");
        if ($sessionId) return $sessionId;

        $sessionId = self::getValue(self::$table, ['id' => $userId], 'session_id');

        RedisService::set("sessionId:{$userId}", $sessionId);

        return $sessionId;
    }

    public function deleteUserSessionIdCache($userId)
    {
        RedisService::delete("sessionId:{$userId}");
    }

    public function getError()
    {
        return $this->error;
    }
}