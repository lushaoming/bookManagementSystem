<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/13
 */
namespace App\Http\Models;

use App\Libs\Tools;

class BookCategory extends BaseModel
{
    public static $table = 'bas_book_category';

    public function getCategories()
    {
        $list = self::getRows(self::$table, [], ['id','name','code','level','pid'], ['id', 'ASC']);
        $list = json_decode(json_encode($list), true);
//        $list = Tools::dealTree($list);
        echo json_encode($list);exit;
    }

    public function getCategory($id)
    {
        return self::getSingleRow(self::$table, ['id' => $id]);
    }
}