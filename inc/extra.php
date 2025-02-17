<?php

if( ! defined( 'ABSPATH' ) ) die; 

if( ! class_exists('RBAO_Admin_Order') ){
    
    class RBAO_Admin_Order{
        public function __construct() {
            add_action( 'init', [$this,'backend_plugin_textdomain'] );
            add_action( 'init', [$this,'define_contstants'] );
            add_action( 'init', [$this,'include_plugin_files'] );

        }

        public static function backend_plugin_textdomain() {
            load_plugin_textdomain( 'multi-day-price-saver-addon-for-wprently', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }

        public function define_contstants(){
            define( 'RBAO_Path', plugin_dir_path(__FILE__) );
            define( 'RBAO_URL', plugin_dir_url(__FILE__) );
            define( 'RBAO_VERSION', RBAO_Admin_Order::get_version() );
            if ( ! defined( 'RBFW_SP_PLUGIN_URL' ) ) {
                define( 'RBFW_SP_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
            }
        }

        public function include_plugin_files(){
            if (is_plugin_active('booking-and-rental-manager-for-woocommerce/rent-manager.php')) {
                require_once(RBAO_Path . "inc/meta.php");
                require_once(dirname(__FILE__) . "/inc/enqueue.php");
            }else {
                add_action('admin_notices', array($this, 'admin_notices_pro'));
            }
        }

        public function admin_notices_pro() {
            $wc_install_url = get_admin_url() . 'plugin-install.php?s=booking-and-rental-manager-for-woocommerce&tab=search&type=term';
            printf('<div class="error" style="background:red; color:#fff;"><p>%s</p></div>', __('You Must Install Rental and Booking Manager Plugin before activating Backend Order for Booking and Rental, Becuase It is fully dependent on that Plugin. <a class="btn button" href=' . $wc_install_url . '>Click Here to Install</a>'));
        }

        public static function get_version(){
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            $plugin_data = get_plugin_data( RBAO_Path . 'additional-day-price.php' );
            return $plugin_data['Version'];
        }

        public static function activate(){
            update_option('rewrite_rules','');
        }

        public static function deactivate(){
            flush_rewrite_rules();
        }

        public static function uninstall(){

        }
    }

}

if( class_exists('RBAO_Admin_Order') ){
    register_activation_hook( __FILE__, array( 'RBAO_Admin_Order','activate' ) );
    register_deactivation_hook( __FILE__, array( 'RBAO_Admin_Order','deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'RBAO_Admin_Order','uninstall' ) );
    new RBAO_Admin_Order();
}


