<?php
// Sbita Bookly Ui Shortcodes

if (!class_exists('BooklyStaffCabinetWooAdmin')) {
    class BooklyStaffCabinetWooAdmin
    {

        /**
         * Admin init
         */
        public static function admin_init()
        {
            add_filter('plugin_action_links_' . sbita_plugin_dir_name(__FILE__) . '/main.php', array(__CLASS__, 'action_links'));
        }

        /**
         * Add links to plugins page
         *
         * @return mixed|string
         */
        public static function action_links($links)
        {

            array_unshift($links, '<a href="' . sbita_settings_url(BooklyStaffCabinetWooSettings::$group_name) . '">' . (__('Settings', 'sbita-bscw')) . '</a>');

            return $links;
        }

    }
}