<?php
// Sbita Bookly Staff Cabinet Woo Settings

if (!class_exists('BooklyStaffCabinetWooSettings')) {
    class BooklyStaffCabinetWooSettings
    {
        public static $group_name = 'Bookly Staff Cabinet Woo';

        public static function main()
        {

        }

        public static function admin_init()
        {
            self::add_settings();
        }

        private static function add_settings()
        {
            // Show staff calender in dashboard
            $whc_option = new SbitaCoreOptionModel('bscw_show_dashboard_calender');
            $whc_option->setDefaultValue('1');
            $whc_option->setDescription(null);
            $whc_option->setInputType('checkbox');
            $whc_option->setLabel(__('Show staff calender in woo account dashboard', 'sbita-bscw'));
            $whc_option->setGroup(self::$group_name);
            $whc_option->add();

            // Title
            $whc_option = new SbitaCoreOptionModel(null);
            $whc_option->setInputType('split');
            $whc_option->setLabel(__('Shortcodes', 'sbita-bscw'));
            $whc_option->setDescription(__('If you leave any items blank they will not be displayed on the account menu items.', 'sbita-bscw'));
            $whc_option->setGroup(self::$group_name);
            $whc_option->add();

            // calender shortcode
            $whc_option = new SbitaCoreOptionModel('bscw_calender_shortcode');
            $whc_option->setDefaultValue('[bookly-staff-calendar]');
            $whc_option->setDescription(null);
            $whc_option->setInputType('text');
            $whc_option->setLabel(__('Staff Calender Shortcode', 'sbita-bscw'));
            $whc_option->setGroup(self::$group_name);
            $whc_option->add();

            // services shortcode
            $whc_option = new SbitaCoreOptionModel('bscw_services_shortcode');
            $whc_option->setDefaultValue('[bookly-staff-services read-only="price"]');
            $whc_option->setDescription(null);
            $whc_option->setInputType('text');
            $whc_option->setLabel(__('Staff Services Shortcode', 'sbita-bscw'));
            $whc_option->setGroup(self::$group_name);
            $whc_option->add();

            // schedule shortcode
            $whc_option = new SbitaCoreOptionModel('bscw_schedule_shortcode');
            $whc_option->setDefaultValue('[bookly-staff-schedule]');
            $whc_option->setDescription(null);
            $whc_option->setInputType('text');
            $whc_option->setLabel(__('Staff Schedule Shortcode', 'sbita-bscw'));
            $whc_option->setGroup(self::$group_name);
            $whc_option->add();

            // special_day shortcode
            $whc_option = new SbitaCoreOptionModel('bscw_special_day_shortcode');
            $whc_option->setDefaultValue('[bookly-staff-special-days]');
            $whc_option->setDescription(null);
            $whc_option->setInputType('text');
            $whc_option->setLabel(__('Staff Special Day Shortcode', 'sbita-bscw'));
            $whc_option->setGroup(self::$group_name);
            $whc_option->add();

            // days_off shortcode
            $whc_option = new SbitaCoreOptionModel('bscw_days_off_shortcode');
            $whc_option->setDefaultValue('[bookly-staff-days-off]');
            $whc_option->setDescription(null);
            $whc_option->setInputType('text');
            $whc_option->setLabel(__('Staff Days Off Shortcode', 'sbita-bscw'));
            $whc_option->setGroup(self::$group_name);
            $whc_option->add();

            // staff details shortcode
            $whc_option = new SbitaCoreOptionModel('bscw_staff_details_shortcode');
            $whc_option->setDefaultValue('[bookly-staff-details]');
            $whc_option->setDescription(null);
            $whc_option->setInputType('text');
            $whc_option->setLabel(__('Staff Details Shortcode', 'sbita-bscw'));
            $whc_option->setGroup(self::$group_name);
            $whc_option->add();

        }


    }
}