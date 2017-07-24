<?php
namespace OSS;

use OSS\OssClient;
use OSS\Core\OssException;

class Oss {
    /**
     * 上传文件根目录
     * @var string
     */
    private $rootPath = 'images';

    private $config = array(
        'accessKeyId' => '',
        'accessKeySecret' => '',
        'endpoint' => '',
        'bucket' => ''
    );
    /**
     * 本地上传错误信息
     * @var string
     */
    private $error = ''; //上传错误信息

    // 设置附件上传类型
    public $exts = array('jpg', 'gif', 'png', 'jpeg');
    //设置文件上传大小，最大5M
    public $maxSize = 5242880;

    public function __construct($config){
        /* 默认Oss配置 */
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 保存指定文件
     * @param  array   $file    保存的文件信息
     * @return boolean          保存状态，true-成功，false-失败
     */
    public function save($file) {
        extract($this->config);
        $filename = $this->rootPath . $file['savepath'] . $file['savename'];
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $ossClient->putObject($bucket, $filename, file_get_contents($file['tmp_name']));
            return true;
        } catch (OssException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * 检查文件大小是否合法
     * @param integer $size 数据
     */
    public function checkSize($size) {
        if (($size > $this->maxSize) && (0 != $this->maxSize)) {
            $this->error = '上传文件大小不符！';
            return false;
        }
        return true;
    }

    /**
     * 检查上传的文件后缀是否合法
     * @param string $ext 后缀
     */
    public function checkExt($ext) {
        if (!empty($this->exts) && !in_array(strtolower($ext), $this->exts)) {
            $this->error = '上传文件后缀不允许';
            return false;
        }
        return true;
    }

    /**
     * 获取最后一次上传错误信息
     * @return string 错误信息
     */
    public function getError(){
        return $this->error;
    }
}