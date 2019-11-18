<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/5
 */
namespace App\Http\Controllers\Admin;

use App\Http\Models\SystemConfigModel;
use App\Libs\ApiCore;

class SystemController extends BaseController {

    public function systemSetting()
    {
        if (request()->method() == 'POST') {
            $posts = request()->post();
            SystemConfigModel::saveSetting($posts);
            return ApiCore::ajaxReturn();
        }

        $configs = SystemConfigModel::getSystemConfig();
        return view('admin.system.setting', [
            'configs' => $configs
        ]);
    }
}