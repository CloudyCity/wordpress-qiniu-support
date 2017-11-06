<?php

namespace Qiniu\WP;


class Config
{

    public static $bucket = "";
    public static $accessKeyId = "";
    public static $accessKeySecret = "";
    public static $endpoint = "";
    public static $storePath = "/";
    public static $uploadDomain = "";
    public static $downloadDomain = "";
    public static $enableImgService = false;
    public static $enableImgStyle = false;
    public static $noLocalSaving = false;

    public static $baseDir = "";

    public static $pluginPath = "qiniu";
    public static $settingsUrl = "options-general.php?page=qiniu-support";
    public static function init($plugin_path = "")
    {
        $plugin_path && self::$pluginPath = plugin_basename($plugin_path);

        $options = array_merge(self::$originOptions, get_option('qiniu_options', array()));
        self::$bucket = $options['bucket'];
        self::$accessKeyId = $options['ak'];
        self::$accessKeySecret = $options['sk'];

        if ($options['uploadDomain'])
            self::$uploadDomain = is_ssl() ? "https://{$options['uploadDomain']}" : "http://{$options['uploadDomain']}";

        if ($options['downloadDomain'])
            self::$downloadDomain = is_ssl() ? "https://{$options['downloadDomain']}" : "http://{$options['downloadDomain']}";

        if ($options['img_service'])
            self::$enableImgService = true;

        $wp_upload_dir = wp_upload_dir();
        self::$baseDir = $wp_upload_dir['basedir'];
        self::$storePath .= trim($options['path'],'/');
        self::$enableImgStyle = $options['img_style'];
        self::$noLocalSaving = $options['nolocalsaving'];
    }

    public static function monthDir($time)
    {
        $wp_upload_dir = wp_upload_dir($time);
        return $wp_upload_dir['path'];
    }

    public static function baseUrl()
    {
        $wp_upload_dir = wp_upload_dir();
        return $wp_upload_dir['baseurl'];
    }

    public static $originOptions = array(
        'bucket'            => "",
        'ak'                => "",
        'sk'                => "",
        'uploadDomain'      => "",
        'downloadDomain'    => "",
        'path'              => "",
        'img_style'         => false,
        'nolocalsaving'     => false,
    );

}