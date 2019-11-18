<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/10/24
 */
namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class BaseModel
{
    public static function save($table, $data, $isCreateTime = true)
    {
        if ($isCreateTime) $data['create_time'] = date('Y-m-d H:i:s');
        DB::table($table)->insert($data);
    }

    public static function saveGetId($table, $data, $isCreateTime = true)
    {
        if ($isCreateTime) $data['create_time'] = date('Y-m-d H:i:s');
        return DB::table($table)->insertGetId($data);
    }

    public static function saveAll($table, $data, $isCreateTime = true)
    {
        if ($isCreateTime) {
            foreach ($data as &$v) {
                $v['create_time'] = date('Y-m-d H:i:s');
            }
        }
        DB::table($table)->insert($data);
    }

    public static function update($table, $where, $data)
    {
        DB::table($table)->where($where)->update($data);
    }

    /**
     * @param $table
     * @param array $where
     * @param string $fields
     * @return mixed
     * @author 卢绍明<lusm@sz-bcs.com.cn>
     * @date   2019/11/7
     */
    public static function getSingleRow($table, $where = [], $fields = '*')
    {
        return DB::table($table)->select($fields)->where($where)->first();
    }

    public static function getRows($table, $where = [], $fields = '*', $orderBy = ['id', 'DESC'])
    {
        return DB::table($table)->select($fields)->where($where)->orderBy($orderBy[0], $orderBy[1])->get();
    }

    public static function paginate($table, $where = [], $fields = '*', $orderBy = ['id', 'DESC'], $limit = 10)
    {
        return DB::table($table)->select($fields)->where($where)->orderBy($orderBy[0], $orderBy[1])->paginate($limit);
    }

    public static function getValue($table, $where = [], $field = '')
    {
        $row = DB::table($table)->select($field)->where($where)->first();
        return $row->$field ?? null;
    }

    public static function getTotal($table, $where)
    {

    }
}