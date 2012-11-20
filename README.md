Stripe.com Political Donations Wordpress Plugin
=================================================================================================

Colophon
-------------------------------------------------------------------------------------------------

Based on the [work by](https://github.com/rcravens/Stripe.com-Wordpress-Plugin) [@rcravens](https://github.com/rcravens), which was, itself, based on the [work by](https://github.com/wlrs/stripe-terminal) [@wlrs](https://github.com/wlrs).


About
-------------------------------------------------------------------------------------------------

This plugin helps you integrate and use Stripe.com in order to solicit campaign donations from your site.

This plugin is built and maintained by [Revolution Messaging, LLC](http://revolutionmessaging.com) and uses the Stripe.com PHP library.

Stripe requires you to have an SSL certificate installed to make live charges, even if you're using `stripe.js`, as this plugin does. The only item that stripe.js alleviates is the need to maintain PCI compliance on your server.


Quick-start
-------------------------------------------------------------------------------------------------

To get started do the following:

1. Download from [Wordpress.org](http://wordpress.org/extend/plugins/stripe-political-donations/) or in your Wordpress Admin control panel by searching for and installing "Stripe Political Donations".
2. Activate the plugin.
3. Configure the plugin via the Admin panel
4. Use the short code (instructions on the Admin panel) to add a payment form


Installation
-------------------------------------------------------------------------------------------------

Go to `Settings -> Stripe Political` and fill out the necessary information.

"Publishable Key" The publishable key from the Stripe.com dashboard.

"Secret Key" The secret key from the Stripe.com dashboard.

"Use Live Keys" Selects whether you want the application to use the live keys. Uses the live keys when checked.

"Currency (3-letter ISO)" In the US, this should be "usd" (without the quotes).

"Prefix" All transactions in Stripe from this application will be prefixed with whatever you put here.

All of the Postmark items are not yet implemented. Even when they are, they'll be optional.


Usage
-------------------------------------------------------------------------------------------------

Place this short tag on the appropriate page or article:

`[stripe_payment amount="" payment_id=""]`

Payment ID & Amount are optional.

Amount can be a single item, or a pipe-delimited set:

`[stripe_payment amount="25"]`

or

`[stripe_payment amount="10|25|50|100"]`


RevMsg Added
-------------------------------------------------------------------------------------------------

1. FEC requirements


Roadmap
-------------------------------------------------------------------------------------------------

1. Convert to use WP_HTTP instead of Walker's included php-httpclient.
2. Send receipt via PostmarkApp (and sendmail?).