<?php
// SbiTa Bookly Staff Cabinet Woo Account

if (!class_exists('BooklyStaffCabinetWooAccount')) {
    class BooklyStaffCabinetWooAccount
    {
        /**
         * Main method
         */
        public static function main()
        {

        }

        /**
         * Init method
         */
        public static function init()
        {
            try {
                if (!class_exists('Bookly\Lib\Entities\Staff'))
                    throw new Exception(__('Not found Bookly Staff Cabinet classes!'));

                self::add_endpoints();
                self::flush_rewrite();
                self::control_current_user();

            } catch (Exception $e) {
                return sbita_show_admin_message($e->getMessage(), false, sbita_plugin_dir_name(__FILE__));
            }
        }

        /**
         * Add endpoints
         */
        private static function add_endpoints()
        {
            add_rewrite_endpoint('booking-staff-cabin-services', EP_ROOT | EP_PAGES);
            add_rewrite_endpoint('booking-staff-cabin-schedule', EP_ROOT | EP_PAGES);
            add_rewrite_endpoint('booking-staff-cabin-staff-days-off', EP_ROOT | EP_PAGES);
            add_rewrite_endpoint('booking-staff-cabin-special-days', EP_ROOT | EP_PAGES);
            add_rewrite_endpoint('booking-staff-cabin-staff-details', EP_ROOT | EP_PAGES);
            add_rewrite_endpoint('booking-staff-cabin-staff-calender', EP_ROOT | EP_PAGES);
        }

        /**
         * Flush rules
         */
        private static function flush_rewrite()
        {
            if (!get_option('_sbscw_flush')) {
                flush_rewrite_rules();
                update_option('_sbscw_flush', true);
            }
        }

        /**
         * Control current user for add items to account page
         */
        private static function control_current_user()
        {
            if (!is_user_logged_in()) return;

            $staff = Bookly\Lib\Entities\Staff::query()
                ->select('id, visibility')
                ->where('wp_user_id', get_current_user_id())
                ->fetchRow();

            if (!$staff) return;

            self::add_items_to_account_page();
        }

        /**
         * Add items to account page
         */
        public static function add_items_to_account_page()
        {

            add_filter('query_vars', array(__CLASS__, 'add_query_vars'), 0);
            add_filter('woocommerce_account_menu_items', array(__CLASS__, 'add_menu_item'));
            add_filter('the_title', array(__CLASS__, 'endpoints_title'), 10, 2);
            self::endpoints_content();
        }

        /**
         * Endpoints content
         */
        private static function endpoints_content()
        {
            add_action('woocommerce_account_booking-staff-cabin-services_endpoint', array(__CLASS__, 'get_services_content'));
            add_action('woocommerce_account_booking-staff-cabin-schedule_endpoint', array(__CLASS__, 'get_schedule_content'));
            add_action('woocommerce_account_booking-staff-cabin-special-days_endpoint', array(__CLASS__, 'get_special_days_content'));
            add_action('woocommerce_account_booking-staff-cabin-staff-days-off_endpoint', array(__CLASS__, 'get_staff_days_off'));
            add_action('woocommerce_account_booking-staff-cabin-staff-details_endpoint', array(__CLASS__, 'get_staff_details'));
            add_action('woocommerce_account_booking-staff-cabin-staff-calender_endpoint', array(__CLASS__, 'get_staff_calendar'));

            if (sbita_get_option('bscw_show_dashboard_calender')) add_action('woocommerce_account_dashboard', array(__CLASS__, 'get_staff_calendar'));
        }

        /**
         * Endpoints title
         */
        public static function endpoints_title($title, $id)
        {
            if (!function_exists('is_account_page') || !is_account_page()) return $title;
            if (!in_the_loop()) return $title;

            global $wp_query;
            $vars = $wp_query->query_vars;
            if (isset($vars['booking-staff-cabin-staff-calender'])) return __('Calender', 'sbita-bscw');
            if (isset($vars['booking-staff-cabin-services'])) return __('Services', 'sbita-bscw');
            if (isset($vars['booking-staff-cabin-schedule'])) return __('Schedule', 'sbita-bscw');
            if (isset($vars['booking-staff-cabin-special-days'])) return __('Special days', 'sbita-bscw');
            if (isset($vars['booking-staff-cabin-staff-days-off'])) return __('Days off', 'sbita-bscw');
            if (isset($vars['booking-staff-cabin-staff-details'])) return __('Staff details', 'sbita-bscw');
            return $title;
        }

        /**
         * Add query vars
         *
         * @param $vars
         * @return mixed
         */
        public static function add_query_vars($vars)
        {
            $vars[] = 'booking-staff-cabin-services';
            $vars[] = 'booking-staff-cabin-schedule';
            $vars[] = 'booking-staff-cabin-staff-days-off';
            $vars[] = 'booking-staff-cabin-special-days';
            $vars[] = 'booking-staff-cabin-staff-details';
            $vars[] = 'booking-staff-cabin-staff-calender';
            return $vars;
        }

        /**
         * Add account menu items
         *
         * @param $items
         * @return mixed
         */
        public static function add_menu_item($items)
        {
            try {
                unset($items['customer-logout']);
                unset($items['edit-account']);

                if (sbita_get_option('bscw_calender_shortcode')) $items['booking-staff-cabin-staff-calender'] = __('Calender', 'sbita-bscw');
                if (sbita_get_option('bscw_services_shortcode')) $items['booking-staff-cabin-services'] = __('Services', 'sbita-bscw');
                if (sbita_get_option('bscw_schedule_shortcode')) $items['booking-staff-cabin-schedule'] = __('Schedule', 'sbita-bscw');
                if (sbita_get_option('bscw_special_day_shortcode')) $items['booking-staff-cabin-special-days'] = __('Special days', 'sbita-bscw');
                if (sbita_get_option('bscw_days_off_shortcode')) $items['booking-staff-cabin-staff-days-off'] = __('Days off', 'sbita-bscw');
                if (sbita_get_option('bscw_staff_details_shortcode')) $items['booking-staff-cabin-staff-details'] = __('Staff details', 'sbita-bscw');

                $items['edit-account'] = __('Account details', 'woocommerce');
                $items['customer-logout'] = __('Logout', 'woocommerce');

                return $items;
            } catch (Exception $e) {
                return $items;
            }
        }

        /**
         * Dashboard content
         */
        public static function get_staff_calendar()
        {
            echo do_shortcode(sbita_get_option('bscw_calender_shortcode'));
        }

        /**
         * Staff details content
         */
        public static function get_staff_details()
        {
            echo do_shortcode(sbita_get_option('bscw_staff_details_shortcode'));
        }

        /**
         * Get services content
         */
        public static function get_services_content()
        {
            echo do_shortcode(sbita_get_option('bscw_services_shortcode'));
        }

        /**
         * Get schedule content
         */
        public static function get_schedule_content()
        {
            echo do_shortcode(sbita_get_option('bscw_schedule_shortcode'));
        }

        /**
         * Get special days content
         */
        public static function get_special_days_content()
        {

            echo do_shortcode(sbita_get_option('bscw_special_day_shortcode'));

        }

        /**
         * Get staff days off
         */
        public static function get_staff_days_off()
        {

            echo do_shortcode(sbita_get_option('bscw_days_off_shortcode'));
        }

    }
}