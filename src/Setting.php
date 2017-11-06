<?php

namespace Qiniu\WP;

class Setting
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'adminMenu'));
        add_filter('plugin_action_links', array($this, 'pluginActionLink'), 10, 2);
        load_plugin_textdomain('qiniu-support', false , Config::$pluginPath.'/languages');

        if ( !(Config::$bucket && Config::$accessKeyId && Config::$accessKeySecret))
            (isset($_GET['page']) && $_GET['page'] == 'qiniu-support') || add_action('admin_notices', array($this, 'warning'));
    }

    /**
     * Registers a new settings page under Settings.
     */
    public function adminMenu()
    {
        add_options_page(
            __('七牛云存储', 'qiniu-support'),
            __('七牛云存储', 'qiniu-support'),
            'manage_options',
            'qiniu-support',
            array($this, 'settingsPage')
        );
    }

    /**
     * 添加设置页面入口连接
     *
     * @param $links
     * @param $file
     * @return array
     */
    function pluginActionLink( $links, $file )
    {
        if ( $file == Config::$pluginPath.'/qiniu-support.php' )
            array_unshift($links, '<a href="'.Config::$settingsUrl.'">'.__('Settings').'</a>');

        return $links;
    }

    public function warning()
    {
        $html = "<div id='qiniu-support-warning' class='updated fade'><p>".
            __('Qiniu Support is almost ready. You should <a href="%s">Setting</a> it to work.', 'qiniu-support').
            "</p></div>";
        echo sprintf($html, Config::$settingsUrl);
    }

    public function settingsPage()
    {
        if (!empty($_POST))
            $this->updateSettings();

        require __DIR__.'/../view/setting.php';
    }

    private function updateSettings()
    {
        $options = get_option('qiniu_options', array());

        isset($_POST['access_key']) && $options['ak'] = trim($_POST['access_key']);
        empty($_POST['access_key_secret']) || $options['sk'] = trim($_POST['access_key_secret']);
        isset($_POST['bucket']) && $options['bucket'] = trim($_POST['bucket']);
        isset($_POST['store_path']) && $options['path'] = trim($_POST['store_path']);
        $options['nolocalsaving'] = isset($_POST['no_local_saving']);
        if (isset($_POST['uploadDomain']))
            $options['uploadDomain'] = preg_replace('/(.*\/\/|)(.+?)(\/.*|)$/', '$2', $_POST['uploadDomain']);
        if (isset($_POST['downloadDomain']))
            $options['downloadDomain'] = preg_replace('/(.*\/\/|)(.+?)(\/.*|)$/', '$2', $_POST['downloadDomain']);

        if (isset($_POST['img_host_enable'])) {
            $options['img_service'] = true;
            $options['img_style'] = isset($_POST['img_style']);
        } else{
            $options['img_service'] = false;
            $options['img_style'] = false;
        }

        isset($_POST['keep_settings']) && $options['keep_settings'] = !!$_POST['keep_settings'];

        unset($options['img_url']);
        if($options['sk']){
	        update_option('qiniu_options', $options);
	        echo '<div class="updated"><p><strong>'. __('The settings have been saved', 'qiniu-support') .'.</strong></p></div>';
        }else{
	        echo '<div class="error"><p>'. __('请填写正确的密钥', 'qiniu-support') .'.</p></div>';
        }

    }
}