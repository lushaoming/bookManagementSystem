<?php
/**
 * 日志
 * User: Shannon
 * Date: 2019/09/25
 */
namespace App\Libs;

class Logger
{
    public static function save($data)
    {
        $path = ROOT_PATH . '/../storage/logs/' . date('Ymd') . '.txt';

        // 数组进行json_decode操作
        if (is_array($data)) $data = json_encode($data);
        $data = '[' . date('Y-m-d H:i:s') . ']'.(ENV != 'pro' ? '[debug]' : '') . ' ' . $data . PHP_EOL;
        file_put_contents($path, $data, FILE_APPEND);
    }
}