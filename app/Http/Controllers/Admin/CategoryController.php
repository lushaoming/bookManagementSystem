<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/13
 */
namespace App\Http\Controllers\Admin;

use App\Http\Models\BookCategory;

class CategoryController extends BaseController
{
    public function index()
    {
        $model = new BookCategory();
        $model->getCategories();
        return view('admin.category.index');
    }
}