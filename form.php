<?php

// Create the html that defines the payment form.
//	Note: Do not add any 'name' attributes to input elements
//	that contain sensitive data. This prevents this data from
//	being posted to your site. All sensitive card holder info
//	is only sent to Stripe.com using HTTPS.
function create_payment_form($amount = null, $paymentId = null, $paymentUrl=STRIPE_PAYMENTS_PAYMENT_URL) {

	if($amount==null) {
		$amounts = array('10', '25', '50', '100');
	} else {
		$amounts = explode('|', $amount);
	}

	if((count($amounts)==1 && !empty($amounts[0])) || (count($amounts)>1)) {
		//nothing
	} else {
		$amounts = array('10', '25', '50', '100');
	}

	if(count($amounts)==1 && !empty($amounts[0])) {
		$amount_fields = '<div class="stripe-payment-form-row">
			<label>Amount (USD $)</label>
			<input type="text" id="cardAmount" size="20" name="amount" class="amount required" value="'.$amounts[0].'" />
			<span class="error"></span>
		</div>';
	} else if(count($amounts)>1) {
		$amount_fields = '<fieldset class="stripe-payment-form-row">
			<legend>Amount <span class="smalltext">(USD $)</span></legend>';
		foreach($amounts as $amount) {
			$amount_fields .= '<span class="radio-amount"><input type="radio" id="card'.$amount.'Amount" name="amount" class="amount required" value="'.$amount.'" /> <label for="card'.$amount.'Amount">$'.$amount.'</label></span>';
		}
		$amount_fields .= '<span class="error"></span>
		</fieldset>';
	} else {
		$amount_fields = '<div class="stripe-payment-form-row">
			<label>Amount (USD $)</label>
			<input type="text" id="cardAmount" size="20" name="amount" class="amount required" value="100" />
			<span class="error"></span>
		</div>';
	}

	return <<<EOT
<div id="stripe-payment-wrap">
	<form action="$paymentUrl" method="post" id="stripe-payment-form">
		<input id="paymentId" type="hidden" name="paymentId" value="$paymentId" />
		<input type="hidden" id="ask" name="ask" value="" />
		<input type="hidden" id="tags" name="tags" value="" />
		$amount_fields
		<div class="stripe-payment-form-row">
			<label>Name on Card</label>
			<input type="text" id="cardName" size="20" name="name" class="required" />
			<span class="error"></span>
		</div>
		<div class="stripe-payment-form-row">
			<label>Email Address</label>
			<input type="text" id="email" size="20" name="email" class="email required" />
			<span class="error"></span>
		</div>
		<div class="stripe-payment-form-row">
			<label>Card Number</label>
			<input type="text" size="20" id="cardNumber" class="number required stripe-sensitive" />
			<span class="error"></span>
		</div>
		<div class="stripe-payment-form-row">
			<label>CVC</label>
			<input type="text" size="4" id="cardCvc" class="number required stripe-sensitive" />
			<span class="error"></span>
		</div>
		<div class="stripe-payment-form-row">
			<label>Expiration</label>
			<select id="cardExpiryMonth" class="required card-expiry-month stripe-sensitive"></select>
			&nbsp;/&nbsp;
			<select id="cardExpiryYear" class="required card-expiry-year stripe-sensitive"></select>
	    </div>

		<div id="sec-info">
			<h3>Employment Information</h3>
		    <div class="stripe-payment-form-row">
				<label>Employer</label>
				<input type="text" id="employer" size="20" name="employer" class="required" />
				<span class="error"></span>
		    </div>
		    <div class="stripe-payment-form-row">
				<label>Occupation</label>
				<input type="text" id="occupation" size="20" name="occupation" class="required" />
				<span class="error"></span>
		    </div>
			<h3>Confirm Eligibility</h3>
		    <div class="stripe-payment-form-row">
				<input type="checkbox" id="eligible" name="eligible" class="required" />
				<label for="eligible" class="eligibility-label" style="float:none;display:inline-block;">I confirm that the following statements are true and accurate:</label>
				<span class="error"></span>
				<ul>
					<li>I am not a foreign national who lacks permanent residence in the United States.</li>
					<li>I am not a Federal government contractor.</li>
					<li>This contribution is made from my own funds, and not those of another.</li>
					<li>This contribution is not made from the funds of a corporation or labor organization.</li>
					<li>This contribution is made on a personal credit card or debit card for which I have the legal obligation to pay, and is not made either on a corporate or business entity card or on the card of another person.</li>
					<li>I am at least eighteen years old.</li>
				</ul>
				<small>Federal law requires us to use our best efforts to collect and report the name, address, occupation and name of employer of individuals whose contributions exceed $200 per election cycle. We may accept contributions from an individual totaling up to $2,500.00 per election.</small>
			</div>
		</div>

	    <div class="stripe-payment-form-row-submit">
			<input id="stripe-payment-form-submit" type="submit" class="button" value="Submit Payment" />
		</div>
		<div class="stripe-payment-form-row-progress">
			<span class="message"></span>
		</div>
	</form>
</div>
EOT;
}