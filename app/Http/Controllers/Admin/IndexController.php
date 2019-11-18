<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/18
 */
namespace App\Http\Controllers\Admin;

use App\Http\Models\Book;
use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{
    public function getStatistics()
    {
        // 总书籍
        $bookTotal = DB::table(Book::$table)->where('status', '<>', 3)->count();
        // 上架的书籍
        $bookTotalNormal = DB::table(Book::$table)->where('status', '=', 1)->count();
        // 总书籍数量
        $bookNumTotal = DB::table(Book::$table)->where('status', '<>', 3)->sum('quantity');
        // 已借数量
        $bookBorrowedNum = DB::table(Book::$table)->where('status', '<>', 3)->sum('borrowed_quantity');
        // 正在借阅数量
        $bookBorrowingNum = DB::table(Book::$table)->where('status', '<>', 3)->sum('borrowing_quantity');
        var_dump($bookTotal);
    }
}