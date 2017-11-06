<?php

/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 17-9-18
 * Time: 下午1:47
 */

namespace QiNiu\WP;

use Qiniu\Auth;
use Qiniu\Http\Error;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Client
{

    private $accessKeyId;

	private $accessKeySecret;

    /**
     * @var Auth
     */
    private $auth;

	/**
	 * 七牛存储空间名
	 * @var string
	 */
	private $bucket;

	/**
	 * 下载域名
	 * @var string
	 */
	private $downloadDomain;

	/**
	 * 上传域名
	 * @var string
	 */
	private $uploadDomain;

    /**
     * @var UploadManager
     */
    protected $uploadManager;

    /**
     * @var BucketManager
     */
	protected $bucketManager;

    public function __construct(){
        $this->accessKeyId     = Config::$accessKeyId;
        $this->accessKeySecret = Config::$accessKeySecret;
	    $this->bucket          = Config::$bucket;
	    $this->uploadDomain    = Config::$uploadDomain;
	    $this->downloadDomain  = Config::$downloadDomain;
    }

    private function getAuth(){
        if(!$this->auth){
            $this->auth = new Auth($this->accessKeyId,$this->accessKeySecret);
        }
        return $this->auth;
    }

    public function getUploadManager(){
        if($this->uploadManager == null){
            $this->uploadManager = new UploadManager();
        }
        return $this->uploadManager;
    }

    public function getBucketManager(){
        if($this->bucketManager == null){
	        $this->auth = $this->auth ?: $this->getAuth();
            $this->bucketManager = new BucketManager($this->auth);
        }
        return $this->bucketManager;
    }

    public function getToken(){
        return $this->getAuth()->uploadToken($this->bucket);
    }

    public function uploadImg($fileName,$filePath){
        list($ret,$err) = $this->getUploadManager()->putFile($this->getToken(),$fileName,$filePath,null);
        $response = new \stdClass();
        if($err !== null){
            $response->err = $err;
            throw new \Exception("上传文件到七牛失败！".var_export($err));
        }else{
            $response->key = $ret['key'];
            $response->hash = $ret['hash'];
        }
        return $response;
    }

    public function generateFilename() {
        return md5(uniqid('', true).$this->accessKeyId . $this->accessKeySecret);
    }

    /**
     * $path对应 ret.key
     * @param $path
     * @return string
     */
    public function generateImageUrl($path){
        if(strtolower(mb_substr($path,0,4)) === "http") return $path;
        return $this->downloadDomain.'/'.$path;
    }

    public function generateSmallImageUrl($path){
        return $this->generateImageUrl($path).'-small';
    }

    /**
     * 生成imageView2链接，原理是缓存在cdn中加速下载，但是没有持久化处理
     * $mode = 0 限定缩略图的长边最多为<LongEdge>，短边最多为<ShortEdge>，进行等比缩放，不裁剪。如果只指定 w 参数则表示限定长边（短边自适应），只指定 h 参数则表示限定短边（长边自适应）。
     * $mode = 1 限定缩略图的宽最少为<Width>，高最少为<Height>，进行等比缩放，居中裁剪。转后的缩略图通常恰好是 <Width>x<Height> 的大小（有一个边缩放的时候会因为超出矩形框而被裁剪掉多余部分）。如果只指定 w 参数或只指定 h 参数，代表限定为长宽相等的正方图。
     * $mode = 2 限定缩略图的宽最多为<Width>，高最多为<Height>，进行等比缩放，不裁剪。如果只指定 w 参数则表示限定宽（长自适应），只指定 h 参数则表示限定长（宽自适应）。它和模式0类似，区别只是限定宽和高，不是限定长边和短边。从应用场景来说，模式0适合移动设备上做缩略图，模式2适合PC上做缩略图。
     * $mode = 3 限定缩略图的宽最少为<Width>，高最少为<Height>，进行等比缩放，不裁剪。如果只指定 w 参数或只指定 h 参数，代表长宽限定为同样的值。你可以理解为模式1是模式3的结果再做居中裁剪得到的。
     * $mode = 4 ss限定缩略图的长边最少为<LongEdge>，短边最少为<ShortEdge>，进行等比缩放，不裁剪。如果只指定 w 参数或只指定 h 参数，表示长边短边限定为同样的值。这个模式很适合在手持设备做图片的全屏查看（把这里的长边短边分别设为手机屏幕的分辨率即可），生成的图片尺寸刚好充满整个屏幕（某一个边可能会超出屏幕）。
     * $mode = 5 限定缩略图的长边最少为<LongEdge>，短边最少为<ShortEdge>，进行等比缩放，居中裁剪。如果只指定 w 参数或只指定 h 参数，表示长边短边限定为同样的值。同上模式4，但超出限定的矩形部分会被裁剪。
     * @param $path
     * @param $mode
     * @param $width
     * @param $height
     * @return string
     */
    public function generateImage2Url($path,$mode,$width,$height){
        $suffix = '?imageView2';
        if(isset($mode)) $suffix.='/'.$mode;
        if(isset($width)) $suffix.='/w/'.$width;
        if(isset($height)) $suffix.='/h/'.$height;
        return $this->generateImageUrl($path).$suffix;

    }

	public function deleteObject($bucket, $fileName){
		$error = $this->getBucketManager()->delete($bucket, $fileName);
		return $error ? false : true;
	}

	public function doesObjectExist($bucket, $object){
		$responseArray = $this->getBucketManager()->stat($bucket, $object);
		foreach ($responseArray as $response){
			if($response && $response instanceof Error){
				$statusCode = $response->code();
				if($statusCode == 612)
					return false;
			}
		}
		return true;
	}
}