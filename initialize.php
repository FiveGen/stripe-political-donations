<?php

// Required PHP files
require_once STRIPE_PAYMENTS_PLUGIN_DIR . '/admin.php';
require_once STRIPE_PAYMENTS_PLUGIN_DIR . '/form.php';
require_once STRIPE_PAYMENTS_PLUGIN_DIR . '/ajax-payment.php';
require_once STRIPE_PAYMENTS_PLUGIN_DIR . '/short-codes.php';

// WP Header Hook (add javascript and css to the page)
add_action('wp_head', 'addHeaderCode', 0);
function addHeaderCode() {
	// Use the global defined in the stripe.php file.
	global $publicKey;
	global $isLiveKeys;

	if (function_exists('wp_enqueue_script')) {
		wp_enqueue_style( 'stripe', STRIPE_PAYMENTS_PLUGIN_URL . '/stripe.css' );

		// add our scripts and their dependencies
		// We're going to manually add jQuery
		wp_enqueue_script('stripe_payment_plugin', STRIPE_PAYMENTS_PLUGIN_URL . '/stripe.js', array('jquery'), '1.5.19');
		wp_enqueue_script('stripe', 'https://js.stripe.com/v1/', array('jquery'), '1.5.19');
		wp_enqueue_script('stripe_payment_plugin', STRIPE_PAYMENTS_PLUGIN_URL . '/stripe.js', array('jquery'), '1.5.19');
		wp_enqueue_script('stripe_configuration', STRIPE_PAYMENTS_PLUGIN_URL . '/stripe_config.php', null, '1.5.19');

		// emit the javascript variable that holds our public strip key
		$isLive = strlen($isLiveKeys)==0?'false':'true';

	}
}