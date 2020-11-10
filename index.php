<?php
/*
    Plugin Name: New Patient Inquiry
    Description: Referralogix’s New Patient Inquiry plugin captures all new patient referrals from your website, in-bound faxes, even cell phone text messages directly into your Referralogix dashboard across your entire healthcare network.
    Plugin URI: http://www.referralogix.com/
    Author: Referralogix
*/


// Enqueue Scripts and Stylesheets
add_action('wp_enqueue_scripts', 'referralogix_enqueue');
function referralogix_enqueue() {

    wp_enqueue_style( 'referralogix_css', plugins_url('/assets/css/styles.css', __FILE__), '1.0');
    
	wp_enqueue_script( 'referralogix_js',plugins_url('/assets/js/script.js', __FILE__) , array( 'jquery'),'1.0' );
	
}


// Admin Script
add_action('admin_enqueue_scripts', 'referralogix_admin_enqueue');
function referralogix_admin_enqueue() {
    
    wp_enqueue_style( 'referralogix_css', plugins_url('/assets/css/styles.css', __FILE__), '1.0');
	wp_enqueue_script( 'referralogix_admin_js',plugins_url('/assets/js/admin.js', __FILE__) , array( 'jquery'),'1.0' );
}


// Include
include_once( plugin_dir_path( __FILE__ ) .'/admin.php');
include_once( plugin_dir_path( __FILE__ ) .'/frontend.php');


// Utilities
if(!function_exists('json_validate')) {

    function json_validate($string){
        $result = json_decode($string);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $result = '';
                break;
            case JSON_ERROR_DEPTH:
                $result = 'Invalid JSON.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $result = 'Invalid JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $result = 'Invalid JSON.';
                break;
            case JSON_ERROR_SYNTAX:
                $result = 'Invalid JSON.';
                break;
            case JSON_ERROR_UTF8:
                $result = 'Invalid JSON.';
                break;
            case JSON_ERROR_RECURSION:
                $result = 'Invalid JSON.';
                break;
            case JSON_ERROR_INF_OR_NAN:
                $result = 'Invalid JSON.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $result = 'Invalid JSON.';
                break;
            default:
                $result = 'Invalid JSON.';
                break;
        }
        return $result;
    }
}
