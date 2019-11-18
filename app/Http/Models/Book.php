<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/13
 */
namespace App\Http\Models;

use App\Libs\Tools;
use Illuminate\Support\Facades\DB;

class Book extends BaseModel
{
    public static $table = 'bas_book';

    public function getList($limit, $keyword)
    {
        $list = DB::table(self::$table)->select('*')->where('book_number', 'like', "%{$keyword}%")
            ->orWhere('book_name', 'like', "%{$keyword}%")
            ->orderBy('id', 'DESC')->paginate($limit);
        foreach ($list as &$item) {
            $item->status_text = $this->dealStatus($item->status);
            $item->book_cover = Tools::dealImageField($item->book_cover, 2);
            if (empty($item->book_cover)) {
                $item->book_cover = Tools::dealBookNoPicture();
            }
        }
        return $list;
    }

    public function dealStatus($status)
    {
        switch ($status) {
            case 1:
                return '正常';
            case 2:
                return '已下架';
            case 3:
                return '已删除';
            case 4:
                return '草稿';
            default:
                return '';
        }
    }

    /**
     * @param $data
     * @return int 插入成功ID
     * @author 卢绍明<lusm@sz-bcs.com.cn>
     * @date   2019/11/16
     */
    public function saveBook($data)
    {
        $save = [
            'book_number' => $data['book_number'],
            'book_name' => $data['book_name'],
            'publish_house' => $data['publish_house'],
            'publish_date' => $data['publish_date'],
            'author' => $data['author'],
            'introduction' => $data['book_introduction'],
            'book_page' => $data['book_page'],
            'quantity' => $data['quantity'],
            'is_allow_comment' => $data['allow_comment'] == 'true' ? 1 : 0,
            'is_allow_borrow' => $data['allow_borrow'] == 'true' ? 1 : 0,
        ];
        if ($data['submit'] == 1) $save['status'] = 1;
        else $save['status'] = 4;

        $save['create_by'] = get_current_admin_user();

        if (isset($data['book_cover'])) {
            foreach ($data['book_cover'] as &$item) {
                unset($item['file_id']);
            }
        }

        $save['book_cover'] = Tools::dealImageField($data['book_cover'] ?? []);

        // 获取最小分类
        if ($data['fourth_cat_selected'] > 0) {
            $save['cat_id'] = $data['fourth_cat_selected'];
        } elseif ($data['third_cat_selected'] > 0) {
            $save['cat_id'] = $data['third_cat_selected'];
        } elseif ($data['second_cat_selected'] > 0) {
            $save['cat_id'] = $data['second_cat_selected'];
        } elseif ($data['first_cat_selected'] > 0) {
            $save['cat_id'] = $data['first_cat_selected'];
        } else {
            $save['cat_id'] = 0;
        }

        return self::saveGetId(self::$table, $save);
    }

    public function getBookTotal()
    {
        return DB::table(self::$table)->where('status', '<>', 3)->count();
    }
}