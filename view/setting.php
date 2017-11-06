<?php
$options = get_option('qiniu_options', array());
$optionsDefault = Qiniu\WP\Config::$originOptions;
$options = array_merge($optionsDefault, $options);
$d = 'qiniu-support';
?>

<div class="wrap" style="margin: 10px;">
    <h1><?php echo __('七牛云存储设置', $d)?></h1>
    <form name="form1" method="post" action="<?php echo Qiniu\WP\Config::$settingsUrl; ?>">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="access_key">AccessKey</label></th>
                <td><input name="access_key" type="text" id="access_key"
                           value="<?php echo $options['ak'] ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="access_key_secret"></label>AccessKeySecret</th>
                <td><input name="access_key_secret" type="text" id="access_key_secret" value=""
                           placeholder="~<?php echo __("You can't see me", $d) ?> ʅ(‾◡◝)" class="regular-text"></td>
            </tr>
            </tbody>
        </table>
        <hr >

        <h2 class="title"><?php echo __('Bucket Settings', $d) ?></h2>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="bucket">Bucket</label></th>
                <td><input name="bucket" type="text" id="bucket" value="<?php echo $options['bucket'] ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="static_host"></label><?php echo __('上传域名', $d) ?></th>
                <td>
                    <input name="uploadDomain" type="text" id="static_host" value="<?php echo $options['uploadDomain'] ?>" class="regular-text host">
                    <?php echo is_ssl()?'<p class="description">'.__('Your site is working under https, please make sure the host can use https too.', $d).'</p>':'' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="static_host"></label><?php echo __('下载域名', $d) ?></th>
                <td>
                    <input name="downloadDomain" type="text" id="static_host" value="<?php echo $options['downloadDomain'] ?>" class="regular-text host">
                    <?php echo is_ssl()?'<p class="description">'.__('Your site is working under https, please make sure the host can use https too.', $d).'</p>':'' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="store_path"></label><?php echo __('Storage Path', $d) ?></th>
                <td><input name="store_path" type="text" id="store_path" value="<?php echo $options['path'] ?>" class="regular-text">
                    <p class="description"><?php echo __("Keep this empty if you don't need.", $d) ?></p></td>
            </tr>
            <tr>
                <th scope="row"><?php echo __('Keep Files', $d) ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php echo __('Keep Files', $d) ?></span></legend>
                        <label for="no_local_saving">
                            <input name="no_local_saving" type="checkbox" id="no_local_saving"
                                <?php echo $options['nolocalsaving'] ? 'checked' : '' ?>> <?php echo __("Don't keep files on local server.", $d) ?>
                        </label>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>
        <hr>

        <h2 class="title"><?php echo __('七牛图片服务设置', $d) ?></h2>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><?php echo __('Image Service', $d) ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php echo __('Image Service Enable', $d) ?></span></legend>
                        <label for="img_host_enable">
                            <input name="img_host_enable" type="checkbox" id="img_host_enable"
                                <?php echo $options['img_service'] || $options['img_url'] ? 'checked' : '' ?>> <?php echo __('Enable', $d) ?>
                        </label>
                    </fieldset>
                    <p class="description"><?php echo __("使用七牛云图片服务来提供不同尺寸的图片，启用后不会再上传缩略图到七牛云", $d) ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo __('Preset Image Style', $d) ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php echo __('Preset Image Style', $d) ?></span></legend>
                        <label for="img_style">
                            <input name="img_style" type="checkbox" id="img_style" <?php echo $options['img_style'] ? 'checked' : '' ?>
                                <?php echo $options['img_service'] ? '' : 'disabled' ?>> <?php echo __('Enable', $d) ?>
                        </label>
                    </fieldset>
                    <p class="description"><?php echo __("可选项，使用 七牛云 图片预设样式来替代通过参数获取缩略图的方式", $d) ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td>
                    <p class="description"><?php echo __("There is a guide about Image Service.", $d) ?> =>
                        <a href="#">
                            <?php echo __("How to use Image Service", $d) ?>
                        </a>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>

        <input name="keep_settings" type="hidden" id="keep_settings" value="<?php echo $options['keep_settings'] ?>">
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Commit', $d)?>"></p>
    </form>
</div>

<script>
    jQuery(function ($) {

        $('input.host').blur(function () {
            var val = $(this).val().replace(/(.*\/\/|)(.+?)(\/.*|)$/, '$2');
            $(this).val(val);
        });

        $('#img_host_enable').change(function () {
            if ($(this).prop('checked')) {
                $('#img_host').attr('disabled', false);
                $('#img_style').attr('disabled', false);
            } else {
                $('#img_host').attr('disabled', true);
                $('#img_style').prop('checked', false).attr('disabled', true);
            }
        });

        $('#internal').change(function () {
            if ($(this).prop('checked')) {
                $('#vpc').attr('disabled', false);
            } else {
                $('#vpc').attr('checked', false).attr('disabled', true);
            }
        })
    })
</script>
