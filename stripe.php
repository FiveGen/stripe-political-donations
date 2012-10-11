<?php
/*
Plugin Name: Political Donations
Plugin URI: http://revolutionmessaging.com/best-of-breed
Description: This plugin turns Wordpress, Stripe.com, and Postmark into the best political donation website ever!!
Author: Revolution Messaging
Version: 1.1.1
Author URI: http://revolutionmessaging.com/
*/

// Settings
$isLiveKeys             = get_option('stripe_payment_is_live_keys');
$isLive                 = $isLiveKeys==0?false:true;
$publicKey              = get_option('stripe_payment_test_public_key');
$secretKey              = get_option('stripe_payment_test_secret_key');
if($isLive) {
    $publicKey          = get_option('stripe_payment_live_public_key');
    $secretKey          = get_option('stripe_payment_live_secret_key');
}
$postmarkKey            = get_option('stripe_postmark_key');
$postmarkFromAddress    = get_option('stripe_postmark_address');
$postmarkFromName       = get_option('stripe_postmark_name');
$postmarkSubject        = get_option('stripe_postmark_subject');
$currencySymbol         = get_option('stripe_payment_currency_symbol');
$transPrefix            = get_option('stripe_payment_trans_prefix');

// Define variables
define( 'STRIPE_PAYMENTS_VERSION', '1.1.1' );

if ( ! defined( 'STRIPE_PAYMENTS_PLUGIN_BASENAME' ) )
    define( 'STRIPE_PAYMENTS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'STRIPE_PAYMENTS_PLUGIN_NAME' ) )
    define( 'STRIPE_PAYMENTS_PLUGIN_NAME', trim( dirname( STRIPE_PAYMENTS_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'STRIPE_PAYMENTS_PLUGIN_DIR' ) )
    define( 'STRIPE_PAYMENTS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . STRIPE_PAYMENTS_PLUGIN_NAME );

if ( ! defined( 'STRIPE_PAYMENTS_PLUGIN_URL' ) )
    define( 'STRIPE_PAYMENTS_PLUGIN_URL', WP_PLUGIN_URL . '/' . STRIPE_PAYMENTS_PLUGIN_NAME );

if ( ! defined( 'STRIPE_PAYMENTS_PAYMENT_URL' ) )
    define( 'STRIPE_PAYMENTS_PAYMENT_URL', WP_PLUGIN_URL . '/payment' );

// Bootstrap this plugin
require_once STRIPE_PAYMENTS_PLUGIN_DIR . '/initialize.php';