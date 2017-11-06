<?php
/**
 * Plugin Name: QiNiu Support
 * Plugin URI: "https://github.com/"
 * Description: 使用七牛作为附件的存储空间。 This is a plugin that used QiNiu for attachments remote saving.
 * Author: CloudyCity
 * Author URI: https://cloudycity.github.io/
 * Version: 0.0.1
 * Updated_at: 2017-10-29
 */

/*  Copyright 2017  CloudyCity  (email : cloudycity@foxmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//自动加载
define('QINIU_SUPPORT_PATH', dirname(__FILE__));
require(QINIU_SUPPORT_PATH.'/autoload.php');

use Qiniu\WP\Config;

//初始化配置
Config::init(QINIU_SUPPORT_PATH);

//插件的配置界面
new Qiniu\WP\Setting();

try {

	//实例化七牛SDK的客户端
    $Client = new Qiniu\WP\Client();

    //挂钩上传相关的函数
    new Qiniu\WP\Upload($Client);

	//挂钩删除相关的函数
	new Qiniu\WP\Delete($Client);

	//挂钩链接相关的函数
    new Qiniu\WP\UrlHelper();

} catch (\Exception $e) {

    echo $e->getMessage();

    //上传异常时使用默认配置
    register_activation_hook(__FILE__, function () {
        add_option('qiniu_options', Config::$originOptions, '', 'yes');
    });

}
