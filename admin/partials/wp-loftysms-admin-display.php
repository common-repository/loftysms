<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.femtosh.com
 * @since      1.0.0
 *
 * @package    Wp_Loftysms
 * @subpackage Wp_Loftysms/admin/partials
 */


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <div class="col-md-8 col-md-offset-2">
        <?php
        settings_errors();
        echo '<span class="text text-success">' . urldecode($_GET['message']) . '</span>';
        ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php echo esc_html(get_admin_page_title()); ?>
            </div>
            <div class="panel-body">
                <form role="form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
                      method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="action" value="save_token">

                    <div class="form-group">
                        <label
                            for="loftysms_token"><?php esc_attr_e('Authorization Token', $this->plugin_name) ?></label>
                        <textarea type="email" class="form-control"
                                  id="loftysms_token"
                                  name="loftysms_token"
                                  required><?php echo $token ?></textarea>
                        <p class="help">
                            <?php _e('Not created an account yet?.', $this->plugin_name); ?>
                            <a target="_blank"
                               href="https://www.loftysms.com/register"><?php _e('Sign Up here.', $this->plugin_name); ?></a>
                        </p>
                        <p class="help">
                            <?php _e('To generate an authorization token on your account?.', $this->plugin_name); ?>
                            <a target="_blank"
                               href="https://www.loftysms.com/user/apps"><?php _e('Click here.', $this->plugin_name); ?></a>
                        </p>
                    </div>
                    <br>
                    <?php submit_button(__('Save Settings', 'primary', 'submit', TRUE)); ?>

                </form>
            </div>
        </div>


    </div>
</div>