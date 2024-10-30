<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.femtosh.com
 * @since      1.0.0
 *
 * @package    Wp_Loftysms
 * @subpackage Wp_Loftysms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Loftysms
 * @subpackage Wp_Loftysms/admin
 * @author     Femtosh Global Solutions <info@femtosh.com>
 */
class Wp_Loftysms_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;
    protected $options;
    protected $host;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->options = get_option($this->plugin_name);
        $this->host = 'https://api.loftysms.com';
        //$this->host = 'http://localhost/loftysms/public/api';


    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Loftysms_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Loftysms_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/css/wp-loftysms-admin.css', array(), $this->version, 'all');
        wp_register_style('loftysms-bootstrap-css', plugin_dir_url(__FILE__) . 'assets/css/bootstrap' . '.min' . '.css', array(), $this->version);
        wp_enqueue_style('loftysms-bootstrap-css');
        wp_register_style('loftysms-bootstrap-theme-css', plugin_dir_url(__FILE__) . 'assets/css/bootstrap-theme' . '.min' . '.css', array(), $this->version);
        wp_enqueue_style('loftysms-bootstrap-theme-css');
        wp_register_style('loftysms-select-css', plugin_dir_url(__FILE__) . 'assets/css/select2' . '.min' . '.css', array(), $this->version);
        wp_enqueue_style('loftysms-select-css');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Loftysms_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Loftysms_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/js/wp-loftysms-admin.js', array('jquery'), $this->version, false);
        wp_register_script('loftysms-bootstrap-js', plugin_dir_url(__FILE__) . 'assets/js/bootstrap' . '.min' . '.js', array(), false);
        wp_register_script('loftysms-select-js', plugin_dir_url(__FILE__) . 'assets/js/select2' . '.min' . '.js', array(), false);
        wp_register_script('loftysms-sendsms-js', plugin_dir_url(__FILE__) . 'assets/js/sendsms' . '.min' . '.js', array(), false);
        wp_enqueue_script('loftysms-bootstrap-js');
        wp_enqueue_script('loftysms-select-js');
        wp_enqueue_script('loftysms-sendsms-js');


    }

    public function add_loftysms_plugin_admin_menu()
    {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        //add_menu_page()
        $menu_items = array(
            'general' => array(
                'title' => __('Loftysms Account Settings', 'wp-loftysms'),
                'text' => __('Settings', 'wp-loftysms'),
                'slug' => 'settings',
                'callback' => array($this, 'LoftysmsDisplaySettingsPage'),
                'position' => 80
            ),
            'post' => array(
                'title' => __('Compose Sms', 'wp-loftysms'),
                'text' => __('Send Sms', 'wp-loftysms'),
                'slug' => '',
                'callback' => array($this, 'DisplaySendSmsPage'),
                'position' => 0
            ),
            'auto' => array(
                'title' => __('Auto Sms Settings', 'wp-loftysms'),
                'text' => __('Auto SMS Settings', 'wp-loftysms'),
                'slug' => 'auto-sms',
                'callback' => array($this, 'AutoSmsSettings'),
                'position' => 0
            ),
        );
        add_menu_page('Loftysms', 'Loftysms', 'manage_options', 'wp-loftysms', array($this, 'DisplaySendSmsPage'), 'http://www.loftysms.com/images/lofty-small.png', '50'
        );
        // sort submenu items by 'position'
        uasort($menu_items, array($this, 'lofysms_sort_menu_items_by_position'));

        // add sub-menu items
        array_walk($menu_items, array($this, 'loftysms_add_menu_item'));
    }

    public function lofysms_sort_menu_items_by_position($a, $b)
    {
        $pos_a = isset($a['position']) ? $a['position'] : 80;
        $pos_b = isset($b['position']) ? $b['position'] : 90;
        return $pos_a < $pos_b ? -1 : 1;
    }

    public function loftysms_add_menu_item(array $item)
    {

        // generate menu slug
        $slug = 'wp-loftysms';
        if (!empty($item['slug'])) {
            $slug .= '-' . $item['slug'];
        }

        // provide some defaults
        $parent_slug = !empty($item['parent_slug']) ? $item['parent_slug'] : 'wp-loftysms';
        $capability = !empty($item['capability']) ? $item['capability'] : 'manage_options';

        // register page
        $hook = add_submenu_page($parent_slug, $item['title'] . ' - Loftysms for Wordpress', $item['text'], $capability, $slug, $item['callback']);

        // register callback for loading this page, if given
        if (array_key_exists('load_callback', $item)) {
            add_action('load-' . $hook, $item['load_callback']);
        }
    }

    public function AutoSmsSettings()
    {
        $checkUser = $this->UserDemography();
        $code = wp_remote_retrieve_response_code($checkUser);
        $message = wp_remote_retrieve_body($checkUser);
        if ($code == 200) {
            $message = json_decode($message);
            include_once('partials/wp-loftysms-admin-autosms.php');
        } elseif ($code == 409) {
            echo '<div class="wrap"><br>&nbsp;<br><div class="col-md-6 col-md-offset-3"><a class="alert alert-danger" href="https://www.loftysms.com/user/settings" target="_blank">Please you need to update your account on Loftysms.com to continue. Click here</a></div></div>';
        } else {
            echo '<div class="wrap"><br>&nbsp;<br><div class="col-md-6 col-md-offset-3"><p class="alert alert-danger">' . $message . '</p></div></div>';

        }
    }

    public function LoftysmsDisplaySettingsPage()
    {
        $token = get_option('wp-loftysms-token');
        include_once('partials/wp-loftysms-admin-display.php');
    }

    function sendsmsscript()
    {

    }

    public function DisplaySendSmsPage()
    {
        $checkUser = $this->UserSendSms();
        $code = wp_remote_retrieve_response_code($checkUser);
        $message = wp_remote_retrieve_body($checkUser);

        if ($code == 200) {
            $message = json_decode($message);
            include_once('partials/wp-loftysms-admin-sendsms.php');
        } elseif ($code == 409) {
            echo '<div class="wrap"><br>&nbsp;<br><div class="col-md-6 col-md-offset-3"><a class="alert alert-danger" href="https://www.loftysms.com/user/settings" target="_blank">Please you need to update your account on Loftysms.com to continue. Click here</a></div></div>';
        } else {
            echo '<div class="wrap"><br>&nbsp;<br><div class="col-md-6 col-md-offset-3"><p class="alert alert-danger">' . $message . '</p></div></div>';

        }

    }

    public function update_loftysms_details()
    {
        if (current_user_can('activate_plugins')) {
            update_option('wp-loftysms-token', $_POST['loftysms_token']);
        }
        add_settings_error(
            $this->plugin_name,
            esc_attr('settings_updated'),
            'Account Linked Successfully',
            'updated'
        );
        $message = urlencode('Token Saved');
        wp_redirect(admin_url() . 'admin.php?page=' . $this->plugin_name . '-settings' . '&message=' . $message);

    }


    public function LinkLoftysmsAccount($input)
    {
        // All checkboxes inputs
        $valid = [];
        $valid['loftysms_username'] = $input['loftysms_username'];
        $valid['loftysms_password'] = $input['loftysms_password'];
        return $valid;
    }

    public function add_action_links($links)
    {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url('/admin.php?page=wp-loftysms-settings') . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);

    }

    public function LoftysmsUser()
    {
        $headers = $this->headers();
        $args = ['headers' => $headers];
        $url = '/me';
        $response = wp_remote_get($this->host . $url, $args);
        return $response;
    }


    public function UserSendSms()
    {
        $headers = $this->headers();
        $args = ['headers' => $headers];
        $url = '/me/sendsms';
        $response = wp_remote_get($this->host . $url, $args);
        return $response;
    }

    public function UserDemography()
    {
        $headers = $this->headers();
        $args = ['headers' => $headers];
        $url = '/me/sendsms/campaign';
        $response = wp_remote_get($this->host . $url, $args);
        return $response;
    }


    public function headers()
    {
        $token = get_option('wp-loftysms-token');
        $headers = array(
            'Authorization' => 'Bearer ' . $token
        );
        return $headers;
    }

    public function loftysms_sendsms()
    {
        //$username = $this->options['loftysms_username'];
        //$password = $this->options['loftysms_password'];
        $headers = $this->headers();
        $args = ['body' => $_POST, 'headers' => $headers];
        $url = '/me/sendsms';
        $response = wp_remote_post($this->host . $url, $args);
        $code = wp_remote_retrieve_response_code($response);
        $message = wp_remote_retrieve_response_message($response);
        if ($code == 400) {
            $message = 'Invalid scheduled date, the date is past';
        } elseif ($code == 405) {
            $message = 'Your Recipients are invalid';
        } elseif ($code == 402) {
            $message = 'Your balance is insuffient to send this message';
        } elseif ($code == 403) {
            $message = 'Your schedule date or time cannot be empty';
        }
        $message = urlencode($message);
        wp_redirect(admin_url() . '/admin.php?page=' . $this->plugin_name . '&code=' . $code . '&message=' . $message);
    }

    public function loftysms_demography_settings()
    {
        $headers = $this->headers();
        $args = ['body' => $_POST, 'headers' => $headers, 'timeout' => 60];
        $url = '/me/sendsms/campaign/confirm';
        $response = wp_remote_post($this->host . $url, $args);
        $code = wp_remote_retrieve_response_code($response);
        $message = wp_remote_retrieve_body($response);
        if ($code == 200) {
            $message = 'Demography settings saved successfully';
            //$autosms_settings = json_encode($_POST);
            if (current_user_can('activate_plugins')) {
                update_option('wp-loftysms-autosms-settings', $_POST);
            }
        }
        $message = urlencode($message);
        wp_redirect(admin_url() . 'admin.php?page=' . $this->plugin_name . '-auto-sms' . '&code=' . $code . '&message=' . $message);
    }

    function loftysms_meta_box($post)
    {
        echo '<label for="loftysmsbroadcast" >' . _e('check to enable SMS broadcast ', $this->plugin_name) . '</label><input type="checkbox" id="loftysmsbroadcast" name="loftysmsbroadcast"/><br/>';
        echo '<label for="loftycustommessage" >' . _e('Custom Message to send ', $this->plugin_name) . '</label><textarea id="loftycustommessage" name="loftycustommessage"></textarea>';

    }

    function loftysmscustommessage($post)
    {
        echo '<label for="loftysmsbroadcast" >' . _e('check to enable SMS broadcast ', $this->plugin_name) . '</label><input type="checkbox" id="loftysmsbroadcast" name="loftysmsbroadcast"/>';
    }

    function AddLoftysmsBroadcastColumn()
    {
        add_meta_box('sms-broadcast', __('SMS Broadcast (powered by Loftysms.com)', $this->plugin_name), array($this, 'loftysms_meta_box'), 'post', 'advanced', 'high');

// New columns to add to table
        /*$new_columns = array(
            'SMS Broadcast' => __('Event Start', 'myplugin_textdomain')
        );

// Remove unwanted publish date column
//unset( $columns['date'] );

// Combine existing columns with new columns
        $filtered_columns = array_merge($columns, $new_columns);

// Return our filtered array of columns
        return $filtered_columns;
    */
    }

    function LoftysmsBroadcastOperation($id)
    {
        $postValues = get_option('wp-loftysms-autosms-settings');
        if ($postValues['loftysms_message_type'] == 'custom') {
            $sms = $_POST['loftycustommessage'];
        } else {
            $link = get_permalink();
            $title = $_POST['post_title'];
            $sms = $title . '. visit ' . $link;
        }


        if (isset($_POST['loftysmsbroadcast']) && $_POST['loftysmsbroadcast'] == "on") {
            if ($sms !== null && !empty($sms)) {
                $headers = $this->headers();
                $postValues['message'] = $sms;
                //$postValues=json_decode($postValues);
                $args = ['body' => $postValues, 'headers' => $headers, 'timeout' => 1200];
                $url = '/me/sendsms/campaign';
                $response = wp_remote_post($this->host . $url, $args);
                //$code = wp_remote_retrieve_response_code($response);
                $message = wp_remote_retrieve_body($response);
                set_transient('loftysms_autopost_message', 'Loftysms: ' . $message);
            }

        }
        //add_action('admin_notices', 'wpsites_admin_notice');


    }

    function wpsites_admin_notice()
    {
        $message = get_transient('loftysms_autopost_message');
        if (strpos($message, 'Loftysms') !== false) {
            delete_transient('loftysms_autopost_message');
            if ($message == "Loftysms: OK") {
                ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php _e('Loftysms: Broadcast Successful', $this->plugin_name); ?></p>
                </div>
                <?php
            } else {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php _e($message, $this->plugin_name); ?></p>
                </div>
                <?php
            }
        }
    }


}
