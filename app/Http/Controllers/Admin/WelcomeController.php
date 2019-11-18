<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/7
 */
namespace App\Http\Controllers\Admin;

use App\Http\Models\AdminUser;
use App\Libs\ApiCore;

class WelcomeController extends BaseController
{
    public function index()
    {
        return view('admin.index');
    }
}