=== Aliyun Storage Support ===
Contributors: ichou
Tags: Qiniu,七牛云存储,storage
Requires at least: 1.0.0
Tested up to: 4.8.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a plugin that used Aliyun Cloud Storage(Aliyun OSS) for attachments remote saving.

== Description ==

本插件主要为 Wordpress 提供基于七牛云存储 的远程附件存储功能，并且最大限度的依赖 Wordpress 本身功能扩展来实现，以保证插件停用或博客搬迁时可以快速切换回原来的方式。

插件特色:

1. 支持 七牛 的图片服务（根据参数获得不同尺寸的图片）
2. 自定义文件在 Bucket 上的存储位置
3. 支持 Https 站点
4. 全格式附件支持，不仅仅是图片
5. 支持 wordpress 4.4+ 新功能 srcset，在不同分辨率设备上加载不同大小图片
6. 图片服务支持预设图片样式，可用于图片打水印的需求
7. 中英文双语支持，方便使用英文为默认语言的同学
8. 代码遵循 PSR-4 规则编写

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
    将插件上传到 `/wp-content/plugins/plugin-name`

2. Activate the plugin through the 'Plugins' screen in WordPress
    激活插件

3. Use the Settings->Qiniu screen to configure the plugin
    在 Settings->七牛云存储 中配置相关参数

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

