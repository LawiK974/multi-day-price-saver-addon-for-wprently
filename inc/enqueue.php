<?php
if ( ! defined( 'ABSPATH' ) ) {
    die;
} // Cannot access pages directly.

add_action('rbfw_admin_enqueue_scripts', 'rbfw_adp_add_admin_scripts');

function rbfw_adp_add_admin_scripts()
{

    wp_enqueue_style('rbfw-sp-admin-style', RBFW_SP_PLUGIN_URL . 'css/admin_style.css', array(),'1.0.0');
    wp_enqueue_script( 'rbfw-sp-admin-script', RBFW_SP_PLUGIN_URL . 'js/admin-script.js', array( 'jquery' ), time(), true );

}