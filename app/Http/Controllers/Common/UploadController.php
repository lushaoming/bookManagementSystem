<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/14
 */
namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Libs\ApiCore;
use App\Libs\Uploader;

class UploadController extends Controller
{
    public function uploadImage()
    {
        $uploader = new Uploader();

        $result = $uploader->image();

        if ($result) {
            $data = [
                'ext' => $uploader->getExt(),
                'origin_name' => $uploader->getOriginName(),
                'file_size' => $uploader->getFileSize(),
                'file_path' => $uploader->getFilePath(),
                'full_path' => $uploader->getFullPath(),
                'secret' => $uploader->getSecret()
            ];
            return ApiCore::ajaxReturn(ApiCore::$returnCode['SUCCESS'], $data);
        } else {
            return ApiCore::ajaxReturn(['code' => $uploader->getCode(), 'msg' => $uploader->getError()]);
        }
    }
}