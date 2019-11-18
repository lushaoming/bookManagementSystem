<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/5
 */
namespace App\Http\Models;

use App\Libs\Redis;
use App\Libs\RedisService;

class SystemConfigModel extends BaseModel
{
    public static $table = 'bas_sys_config';
    public static $cacheKey = 'system_settings';

    /**
     * @param string $key
     * @return array|bool|mixed|string|null
     * @author 卢绍明<lusm@sz-bcs.com.cn>
     * @date   2019/11/7
     */
    public static function getSystemConfig($key = '')
    {
        $ret = RedisService::get(self::$cacheKey);
        if ($ret) {
            $ret = unserialize($ret);
        } else {
            $list = self::getRows(self::$table, [], '*', ['list_order', 'ASC']);

            $ret = [];
            foreach ($list as $item) {
                if (in_array($item->element_type, ['radio', 'checkbox', 'select'])) {
                    $item->element_options = unserialize($item->element_options);
                }
                $ret[$item->type][] = $item;
            }

            RedisService::set(self::$cacheKey, serialize($ret));
        }

        if ($key) {
            $keys = explode('.', $key);
            if (count($keys) == 1) {
                return $ret[$key] ?? null;
            } else {
                $configs = $ret[$keys[0]] ?? [];
                foreach ($configs as $config) {
                    if ($config->config_key == $keys[1]) {
                        return $config->config_value;
                    }
                }
                return null;
            }
        }

        return $ret;
    }

    public static function saveSetting($settings)
    {
        foreach ($settings as $key => $setting) {
            self::update(self::$table, ['config_key' => $key], ['config_value' => $setting]);
        }

        RedisService::delete(self::$cacheKey);
    }

}