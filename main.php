<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly
/*
Plugin Name: SbiTa Bookly Staff Cabinet to Woo (Add-on)
Description: SbiTa Bookly Staff Cabinet to Woo add-on is a plugin for add Bookly Staff Cabinet (add-on) to Woocommerce Account page for staff members.
Version: 1.0
Author: Webhead
Text Domain: sbita-bscw
Domain Path: /languages
*/


if (!class_exists('SbitaBooklyCabinetWoo')) {
    define('SBWC_TMP_DIR', path_join(plugin_dir_path(__FILE__), 'templates'));

    require_once ABSPATH . 'wp-admin/includes/plugin.php';

    include plugin_dir_path(__FILE__) . '/incloude/functions.php';
    include plugin_dir_path(__FILE__) . '/incloude/bookly-staff-cabinet-woo-account.php';
    include plugin_dir_path(__FILE__) . '/incloude/bookly-staff-cabinet-woo-settings.php';


    class SbitaBooklyCabinetWoo
    {
        /**
         * Main Method
         */
        public static function main()
        {
            $result = is_plugin_active('sbita/main.php') && is_plugin_active('bookly-addon-staff-cabinet/main.php');
            if (!$result) return self::need_core_message();

            add_action('plugins_loaded', array(__CLASS__, 'textdomain'));
            add_action('init', array(__CLASS__, 'init'));
            add_action('admin_init', array(__CLASS__, 'admin_init'));

            BooklyStaffCabinetWooAccount::main();
            BooklyStaffCabinetWooSettings::main();
        }

        /**
         * Init plugin
         */
        public static function init()
        {
            BooklyStaffCabinetWooAccount::init();
        }

        /**
         * Init plugin
         */
        public static function admin_init()
        {
            BooklyStaffCabinetWooSettings::admin_init();
        }


        /**
         * Load textdomain
         *
         * @return void
         */
        public static function textdomain()
        {
            load_plugin_textdomain('sbita-bscw', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        }

        /**
         * Core message
         *
         */
        public static function need_core_message()
        {
            add_action('admin_notices', function () {
                echo "
                <div class='notice notice-error is-dismissible'>
                        <p>SbiTa Bookly Staff Cabinet to Woo: Need `SbiTa`  and 
                        <a href='https://wordpress.org/plugins/bookly-responsive-appointment-booking-tool/'>Bookly</a>
                        plugins!</p>
                </div>";
            });
            return null;
        }
    }

    SbitaBooklyCabinetWoo::main();

}