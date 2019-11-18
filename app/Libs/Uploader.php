<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/14
 */
namespace App\Libs;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Uploader
{
    const SAVE_DIR_NAME = 'storage';
    const FILE_UPLOAD_SUCCEED = 0;
    const FILE_VALIDATE_FAIL = -4001;
    const FILE_UPLOAD_FAIL = -4002;

    protected $code;
    protected $error;
    protected $filePath;
    protected $fullPath;
    protected $originFileName;
    protected $fileSize;
    protected $ext;
    protected $secret;

    public function image($fileKey = 'file')
    {
        $request = request();
        $validator = Validator::make($request->all(), [
            $fileKey => 'required|image'
        ]);

        if ($validator->fails()) {
            $this->setValidateFail();
        } else {
            $file = $request->file($fileKey);
            $this->originFileName = $file->getClientOriginalName();
            $this->fileSize = $file->getSize();
            $this->ext = $file->getClientOriginalExtension();
            $fileName = $this->getFileDir().'/'.$this->createFileName() . '.' . $this->ext;

            //MimeType
            $type = $file->getMimeType();
            Logger::save('Mime type: '.$type);
            //临时绝对路径
            $realPath = $file->getRealPath();
            $result = Storage::disk('public')->put($fileName, file_get_contents($realPath));

            if ($result) {
                $this->setSecret();
                $this->setFilePath($fileName);
                $this->setUploadSucceed();
            } else {
                $this->setUploadFail();
            }

            return $result;
        }
    }

    protected function getFileDir()
    {
        $baseDir = ROOT_PATH.'/../storage/app/public/';
        $dir = date('Ym').'/'.date('d');
        if (!is_dir($baseDir.$dir)) {
            mkdir($baseDir.$dir, 0777, true);
        }
        return $dir;
    }

    protected function setValidateFail()
    {
        $this->code = self::FILE_VALIDATE_FAIL;
        $this->error = '你上传的文件不合法';
    }

    protected function setUploadSucceed()
    {
        $this->code = self::FILE_UPLOAD_SUCCEED;
        $this->error = 'OK';
    }

    protected function setUploadFail()
    {
        $this->code = self::FILE_UPLOAD_FAIL;
        $this->error = '上传失败';
    }

    protected function createFileName()
    {
        return md5(time() . $this->createNonce());
    }

    protected function setFilePath($fileName)
    {
        $this->filePath = self::SAVE_DIR_NAME.'/'.$fileName;
    }

    protected function setSecret()
    {
        $this->secret = $this->createNonce();
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function getFullPath()
    {
        return asset($this->filePath);
    }

    public function getOriginName()
    {
        return $this->originFileName;
    }

    public function getFileSize()
    {
        return $this->fileSize;
    }

    public function getExt()
    {
        return $this->ext;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getError()
    {
        return $this->error;
    }

    /**
     * 获取一个随机字符串
     * @param int $length 字符串长度
     * @return string
     */
    protected function createNonce($length = 8)
    {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $return_str = '';
        for ($i = 0; $i < $length; $i ++) {
            $rant = mt_rand(0, mb_strlen($str) - 1);
            $return_str .= mb_substr($str, $rant, 1);
        }
        return $return_str;
    }
}