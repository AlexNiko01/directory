<?php

/*
Plugin Name: AIT PayPal Payments
Version: 1.6
Description: Adds PayPal gateway to City Guide Theme

Author: AitThemes.Club
Author URI: http://ait-themes.club
Text Domain: ait-paypal-payments
Domain Path: /languages
*/

defined('ABSPATH') or die();
include_once(dirname(__FILE__).'/load.php');

add_action('after_setup_theme', function() {
	try {
		define('AIT_PAYPAL_LISTENER_URL', plugin_dir_url(__FILE__).'listener.php');
		AitPaypal::getInstance();
	} catch (Exception $e) {
		AitPaypal::error($e);
	}
});

register_activation_hook(__FILE__, function(){
	AitCache::clean();
});

add_action('plugins_loaded', function() {
	load_plugin_textdomain('ait-paypal-payments', false, dirname(plugin_basename( __FILE__ )) . '/languages');
}, 11);