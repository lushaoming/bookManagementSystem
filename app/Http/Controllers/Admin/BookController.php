<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/13
 */
namespace App\Http\Controllers\Admin;

use App\Http\Models\AdminUserOperationLog;
use App\Http\Models\Book;
use App\Libs\ApiCore;
use Illuminate\Http\Request;

class BookController extends BaseController
{
    public function index()
    {
        if (request()->ajax()) {
            $limit = ApiCore::getVar('limit', 10);
            $keyword = ApiCore::getVar('keyword', '');
            $model = new Book();
            $list = $model->getList($limit, $keyword);

            return ApiCore::ajaxReturn(ApiCore::$returnCode['SUCCESS'], $list);
        }
        return view('admin.book.index');
    }

    public function add(Request $request)
    {
        if (request()->method() === self::METHOD_POST) {
            $this->validate($request, [
                'book_name' => 'required',
                'book_number' => 'required',
                'publish_house' => 'required',
                'publish_date' => 'required',
                'author' => 'required',
                'book_page' => 'required|numeric',
                'book_introduction' => 'required',
                'quantity' => 'required|numeric'
            ]);
            $model = new Book();
            $id = $model->saveBook($request->input());
            AdminUserOperationLog::saveLog(get_current_admin_user(), "新增了一本书籍，ID：{$id}");
            return ApiCore::ajaxReturn();
        }
        return view('admin.book.add');
    }



}