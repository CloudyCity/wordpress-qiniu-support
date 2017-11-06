# 七牛云存储 支持插件 (Qiniu support For WordPress)

本插件是在[基于阿里云OSS的WordPress远程附件支持插件](https://github.com/IvanChou/aliyun-oss-support)上修改而成。主要为 Wordpress 提供基于七牛的远程附件存储功能，并且最大限度的依赖 Wordpress 本身功能扩展来实现，以保证插件停用或博客搬迁时可以快速切换回原来的方式。

## 当前版本

Stable: `1.0.0`

## 插件特色

1. 支持 七牛云存储 的图片服务（根据参数获得不同尺寸的图片）
2. 自定义文件在 Bucket 上的存储位置  
3. 支持 Https 站点
4. 全格式附件支持，不仅仅是图片
5. 持 wordpress 4.4+ 新功能 srcset，在不同分辨率设备上加载不同大小图片
6. 务支持预设图片样式，可用于图片打水印的需求
7. 中英文双语支持，方便使用英文为默认语言的同学
8. 代码遵循 PSR-4 规则编写


### 安装

将插件解压上传到 `/wp-content/plugins/` 或者通过 WordPress 插件中心上传安装

注意上传时 zip 包的名字,建议使用 `qiniu-support.zip`

### 配置

启用插件 `Qiniu Support`

进入设置页面 完成相关设置

![screenshot](https://github.com/CloudyCity/wordpress-qiniu-support/blob/master/screenshot.jpg)

## 关于图片服务

七牛 提供了根据 url 参数来获得各种尺寸的 `七牛图片处理服务（Image Service，简称 IMG）`, 相比起 WordPress 自身在图片上传的时候生成各种尺寸的图片, 明显是一种更优雅的解决方案, 占用的存储空间更小, 尺寸变更更灵活。

通常使用中, 你不需要特别的去了解它的实现, 只需注意: 

1. 开启图片服务时, 只有原图会被上传到 七牛, 如果此时关闭图片服务, 服务开启这段时间内上传的图片会出现缩略图丢失的情况
2. 如果没有开启 不在本地服务器上保留文件 选项, 服务器上仍旧保留有缩略图, 此时关闭插件会发现所有的缩略图其实都在, 所以你可以通过手动上传到 七牛 来修复丢失问题
3. 如果开启了 不在本地服务器上保留文件 选项, 那就真的找不回那些丢失的缩略图了 ㄟ( ▔, ▔ )ㄏ

****

## 冲突列表

- EvernoteSync
- ultimate member
- BuddyPress

## 贡献代码

1. Fork 这个仓库
2. Clone 源码并安装到本地 WordPress 中
3. 完成你的修改并测试
4. 提交一个 Pull Request

## 开源协议

BSD

