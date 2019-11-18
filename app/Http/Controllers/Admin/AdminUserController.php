<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/7
 */
namespace App\Http\Controllers\Admin;

use App\Http\Models\AdminUser;
use App\Libs\ApiCore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminUserController extends BaseController
{
    public function login(Request $request)
    {
        if (request()->method() == ApiCore::METHOD_POST) {
            $this->validate($request, [
                'captcha' => 'required|captcha'
            ]);
            if (check_admin_user_is_logged_in()) {
                return ApiCore::ajaxReturn(ApiCore::$returnCode['HAS_LOGIN']);
            }
            $username = ApiCore::getNotEmptyVar('username', '用户名不能为空');
            $password = ApiCore::getNotEmptyVar('password', '密码不能为空');
            $remember = ApiCore::getVar('remember', 0);

            $adminUser = new AdminUser();
            $id = $adminUser->login($username, $password, (bool)$remember);
            if ($id > 0) {
                return ApiCore::ajaxReturn();
            } else {
                return ApiCore::ajaxReturn(['code' => 400, 'msg' => $adminUser->getError()]);
            }
        }

        if (check_admin_user_is_logged_in()) {
            return redirect('/');
        }
        return view('admin.login');
    }

    public function logout()
    {
        session([
            'admin_id' => null,
            'admin_username' => null,
            'admin_nickname' => null,
        ]);
        return redirect('/login');
    }
}