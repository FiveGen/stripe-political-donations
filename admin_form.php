<?php
	if($_POST) {
		// Form data sent
		$livePublicKey = $_POST['live_public_key'];
		update_option('stripe_payment_live_public_key', $livePublicKey);
		
		$liveSecretKey = $_POST['live_secret_key'];
		update_option('stripe_payment_live_secret_key', $liveSecretKey);
		
		$testPublicKey = $_POST['test_public_key'];
		update_option('stripe_payment_test_public_key', $testPublicKey);
		
		$testSecretKey = $_POST['test_secret_key'];
		update_option('stripe_payment_test_secret_key', $testSecretKey);
		
		$isLiveKeys = $_POST['is_live_keys'];
		update_option('stripe_payment_is_live_keys', $isLiveKeys);
		
		$currencySymbol = $_POST['currency_symbol'];
		update_option('stripe_payment_currency_symbol', $currencySymbol);
		
		$transPrefix = $_POST['trans_prefix'];
		update_option('stripe_payment_trans_prefix', $transPrefix);
		
		$ellaKey = $_POST['ella_key'];
		update_option('stripe_payment_ella_key', $ellaKey);
		
		$ellaSecret = $_POST['ella_secret'];
		update_option('stripe_payment_ella_secret', $ellaSecret);
		
		$postmarkKey = $_POST['postmark_key'];
		update_option('stripe_postmark_key', $postmarkKey);
		
		$postmarkFromAddress = $_POST['postmark_from_address'];
		update_option('stripe_postmark_address', $postmarkFromAddress);
		
		$postmarkFromName = $_POST['postmark_from_name'];
		update_option('stripe_postmark_name', $postmarkFromName);
		
		$postmarkSubject = $_POST['postmark_subject'];
		update_option('stripe_postmark_subject', $postmarkSubject);
		?>
		
		<div class="updated"><p><strong><?php _e('Options saved.'); ?></strong></p></div>
		
		<?php
	} else {
		// Normal page display
		$livePublicKey 			= get_option('stripe_payment_live_public_key');
		$liveSecretKey 			= get_option('stripe_payment_live_secret_key');
		$testPublicKey 			= get_option('stripe_payment_test_public_key');
		$testSecretKey 			= get_option('stripe_payment_test_secret_key');
		$isLiveKeys 			= get_option('stripe_payment_is_live_keys');
		$currencySymbol 		= get_option('stripe_payment_currency_symbol');
		$transPrefix 			= get_option('stripe_payment_trans_prefix');
		$ellaKey 				= get_option('stripe_payment_ella_key');
		$ellaSecret 			= get_option('stripe_payment_ella_secret');
		$postmarkKey 			= get_option('stripe_postmark_key');
		$postmarkFromAddress 	= get_option('stripe_postmark_address');
		$postmarkFromName 		= get_option('stripe_postmark_name');
	}
	
?>


<div id="stripe-payments-admin-wrap" class="wrap">
	<h2>Stripe Payments - Options</h2>
	
	<h4>Instructions</h4>
	<div class="instructions">
		<p>To add a payment form to a page or post use the following short code:</p>
		<code>
			[stripe_payment amount=100.0]
		</code>
		<ul>
			<li><strong>amount</strong> - The amount that will be shown in the form.</li>
		</ul>
	</div>
	<form name="stripe_payment_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<p class="info">Log into <a href="http://stripe.com" target="_blank">stripe.com</a> to access your keys and determine the 3-letter ISO code for currency.</p>
		<h4>Live Keys</h4>
		<p>These keys are configured to a real account and <strong>will</strong> result in actual credit card charges.</p>
		<ul>
			<li>
				<label for="live_public_key">Publishable Key:</label>
				<input type="text" name="live_public_key" value="<?php echo $livePublicKey; ?>" />
			</li>
			<li>
				<label for="live_secret_key">Secret Key:</label>
				<input type="text" name="live_secret_key" value="<?php echo $liveSecretKey; ?>" />
			</li>
		</ul>
		<h4>Test Keys</h4>
		<p>These keys are configured to a test account and <strong>will not</strong> result in actual credit card charges.</p>
		<ul>
			<li>
				<label for="test_public_key">Publishable Key:</label>
				<input type="text" name="test_public_key" value="<?php echo $testPublicKey; ?>" />
			</li>
			<li>
				<label for="test_secret_key">Secret Key:</label>
				<input type="text" name="test_secret_key" value="<?php echo $testSecretKey; ?>" />
			</li>
		</ul>
		<h4>Other</h4>
		<p>The following string will stored as a prefix for all transactions processed by this plugin.</p>
		<ul>
			<li>
				<label for="is_live">Use Live Keys?:</label>
				<input type="checkbox" name="is_live_keys" <?php if($isLiveKeys){echo 'checked=checked';} ?> />
				<span>Leave unchecked for testing. Check when you are ready to <strong>go live</strong>.</span>
			</li>
			<li>
				<label for="currency_symbol">Currency Symbol:</label>
				<input type="text" name="currency_symbol" value="<?php echo $currencySymbol; ?>" />
				<span>Visit <a href="http://stripe.com">stripe.com</a> to determine the appropriate 3-letter ISO code. (e.g. usd)</span>
			</li>
			<li>
				<label for="trans_prefix">Prefix:</label>
				<input type="text" name="trans_prefix" value="<?php echo $transPrefix; ?>" />
				<span>This will prefix all transactions in the stripe dashboard. (e.g. Terminal)</span>
			</li>
		</ul>
		<h4>Ella Integration for Advanced Reporting (optional)</h4>
		<p>These keys allow you to pull reports in Revere Dashboard later.</p>
		<ul>
			<li>
				<label for="ella_key">Key:</label>
				<input type="text" name="ella_key" value="<?php echo $ellaKey; ?>" />
			</li>
			<li>
				<label for="ella_secret">Secret:</label>
				<input type="text" name="ella_secret" value="<?php echo $ellaSecret; ?>" />
			</li>
		</ul>
		
		<h4>Postmark Receipt Email (optional)</h4>
		<p>Use your <a href="http://postmarkapp.com">postmarkapp.com</a> account to send a styled email receipt.</p>
		<ul>
			<li>
				<label for="postmark_key">API Key:</label>
				<input type="text" name="postmark_key" value="<?php echo $postmarkKey; ?>" />
			</li>
			<li>
				<label for="postmark_from_address">From Email Address:</label>
				<input type="text" name="postmark_from_address" value="<?php echo $postmarkFromAddress; ?>" />
			</li>
			<li>
				<label for="postmark_from_name">From Name:</label>
				<input type="text" name="postmark_from_name" value="<?php echo $postmarkFromName; ?>" />
			</li>
			<li>
				<label for="postmark_subject">Subject:</label>
				<input type="text" name="postmark_subject" value="<?php echo $postmarkSubject; ?>" />
			</li>
		</ul>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="Submit" value="<?php _e('Save Options'); ?>" />
		</p>
	</form>
</div>
