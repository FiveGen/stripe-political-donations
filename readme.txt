=== Stripe Political Donations ===
Contributors: signalfade
Tags: donations, FEC, politics, fundraising, stripe.com, stripe, contributions
Requires at least: 3.0.0
Tested up to: 3.3.2
Stable tag: 1.1.3

This plugin helps you integrate and use Stripe.com in order to solicit campaign donations from your site.

== Description ==

This plugin helps you integrate and use Stripe.com in order to solicit campaign donations from your site.

This plugin is built and maintained by [Revolution Messaging, LLC](http://revolutionmessaging.com) and uses the Stripe.com PHP library.

Stripe requires you to have an SSL certificate installed to make live charges, even if you're using `stripe.js`, as this plugin does. The only item that stripe.js alleviates is the need to maintain PCI compliance on your server.

== Installation ==

Go to `Settings -> Stripe Political` and fill out the necessary information.

"Publishable Key" The publishable key from the Stripe.com dashboard.

"Secret Key" The secret key from the Stripe.com dashboard.

"Use Live Keys" Selects whether you want the application to use the live keys. Uses the live keys when checked.

"Currency (3-letter ISO)" In the US, this should be "usd" (without the quotes).

"Prefix" All transactions in Stripe from this application will be prefixed with whatever you put here.

All of the Postmark items are not yet implemented. Even when they are, they'll be optional.

== Usage ==

Place this short tag on the appropriate page or article:

`[stripe_payment amount="" payment_id=""]`

Payment ID & Amount are optional.

Amount can be a single item, or a pipe-delimited set:

`[stripe_payment amount="25"]`

or

`[stripe_payment amount="10|25|50|100"]`