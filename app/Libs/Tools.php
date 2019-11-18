<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/13
 */
namespace App\Libs;

class Tools
{
    /**
     * 非递归处理树形结构的数据
     * @param $data
     * @param string $pName
     * @param string $child
     * @return array
     * @author 卢绍明<lusm@sz-bcs.com.cn>
     * @date   2019/11/13
     */
    public static function dealTree($rows, $id='id', $pid='pid', $child = 'child')
    {
        $items = array();

        foreach ($rows as $row) {
            $items[$row[$id]] = $row;
        }

        foreach ($items as $item) {
            $items[$item[$pid]][$child][$item[$id]] = &$items[$item[$id]];
        }

        return isset($items[0][$child]) ? $items[0][$child] : [];
    }

    public static function dealImageField($data, $action = 1)
    {
        if ($action == 1) {
            return serialize($data);
        } else {
            return unserialize($data) ?: [];
        }
    }

    public static function dealBookNoPicture()
    {
        return [
            [
                'ext' => 'png',
                'origin_name' => 'no_picture.png',
                'file_size' => 0,
                'file_path' => '/img/no_picture.png',
                'full_path' => '/img/no_picture.png'
            ]
        ];
    }
}