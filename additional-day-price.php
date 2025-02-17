<?php
/**
 * Plugin Name: Booking and Rental Manager Addon: Multi day price saver
 * Plugin URI: https://mage-people.com/product/booking-and-rental-manager-for-woocommerce-pro/
 * Description: Booking order from backend dashboard.
 * Version: 1.0.0
 * Author: MagePeople Team
 * Author URI: https://www.mage-people.com/
 * Text Domain: multi-day-price-saver-addon-for-wprently
 * Domain Path: /languages/
 *
 *
 */


if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( ! defined( 'RBFW_SP_PLUGIN_URL' ) ) {
    define( 'RBFW_SP_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
}
if ( ! defined( 'RBFW_AD_PLUGIN_DIR' ) ) {
    define( 'RBFW_AD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if (!defined('MEP_STORE_URL')) {
    define('MEP_STORE_URL', 'https://mage-people.com/');
}

define('RBFW_PRO_SP_ID', 113155);



require_once(RBFW_AD_PLUGIN_DIR . "/inc/file_include.php");



