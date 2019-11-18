<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/12
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\AdminUser;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{
    public function index()
    {
        $action = request()->input('action', '');
        switch ($action) {
            case 'heartbeat':
                $ret['server_time'] = time();
                if (check_admin_user_is_logged_in()) {
                    if (Session::getId() != AdminUser::getLastSessionId(get_current_admin_user())) {
                        $ret['auth_check'] = false;
                        $ret['logout'] = 2;
                        clear_login_session();
                    } else {
                        $ret['auth_check'] = true;
                    }
                } else {
                    $ret['auth_check'] = false;
                    $ret['logout'] = 1;
                }
                echo json_encode($ret);
                break;
            default:
                break;
        }
    }
}