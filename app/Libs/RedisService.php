<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/13
 */
namespace App\Libs;

use \Illuminate\Support\Facades\Redis;
class RedisService
{
    /**
     * @param string $key 键名
     * @param string $value 键值
     * @param int $expire 有效期，单位秒
     * @author 卢绍明<lusm@sz-bcs.com.cn>
     * @date   2019/11/13
     */
    public static function set(string $key, string $value, int $expire = 3600)
    {
        Redis::setex(REDIS_GROUP.'/'.$key, $expire, $value);
    }

    /**
     * @param string $key 键名
     * @return mixed
     * @author 卢绍明<lusm@sz-bcs.com.cn>
     * @date   2019/11/13
     */
    public static function get(string $key)
    {
        return Redis::get(REDIS_GROUP.'/'.$key);
    }

    /**
     * @param string $key 键名
     * @return mixed
     * @author 卢绍明<lusm@sz-bcs.com.cn>
     * @date   2019/11/13
     */
    public static function delete(string $key)
    {
        return Redis::del(REDIS_GROUP.'/'.$key);
    }
}