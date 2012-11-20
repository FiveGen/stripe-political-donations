<?php

// register the ajax process function with wordpress
add_action("wp_ajax_stripe_plugin_process_card", "stripe_plugin_process_card");
add_action("wp_ajax_nopriv_stripe_plugin_process_card", "stripe_plugin_process_card");

function stripe_plugin_process_card() {

    // Use the globals defined in stripe.php
    global $secretKey;
    global $currencySymbol;
    global $transPrefix;

    // Create the response array
    $response = array(
        'success' => false
    );

    if($_POST) {
        // Load the official Stripe PHP bootstrap file
        require_once STRIPE_PAYMENTS_PLUGIN_DIR.'/stripe-php-1.7.7/lib/Stripe.php';

        // Extract the extra data
        $meta = array();
        if($transPrefix) {
            $meta['prefix'] = $transPrefix;
        }
        if($_POST['email']) {
            $meta['email'] = $_POST['email'];
        }
        if($_POST['name']) {
            $meta['name'] = $_POST['name'];
        }
        if($_POST['employer']) {
            $meta['employer'] = $_POST['employer'];
        }
        if($_POST['occupation']) {
            $meta['occupation'] = $_POST['occupation'];
        }
        if($_POST['eligible']) {
            $meta['eligible'] = $_POST['eligible'];
        }
        if($_POST['paymentId']) {
            $meta['paymentId'] = $_POST['paymentId'];
        }

        if($_POST['amount']) {
            setlocale(LC_MONETARY, 'en_US');
            $amount = money_format('%.2n', $_POST['amount']);
            $amount = str_replace('$', '', $amount);
            $amount = $amount*100;
        }

        // Create the data to submit to Stripe's secure processing
        //  Note: Card number data is not accessible. The code can
        //  only access a 'token' that was previously generated by
        //  Stripe via AJAX post.
        $params = array(
            'amount'        => $amount,
            'currency'      => $currencySymbol,
            'card'          => $_POST['token'],
            'description'   => array_implode(':=', '|', $meta)
        );

        $meta['currency'] = $currencySymbol;
        $meta['token'] = $_POST['token'];
        $meta['amount'] = $_POST['amount']/100;

        $potential_total = 0; //2500;

        // FUTURE FEATURE
        // Run check for total here ($2500/election)
        if(2500 <= $potential_total+($_POST['amount']/100) && $meta['eligible']=='agreed') {
            // They've already given too much!
            $response['error'] = 'We believe you\'ve already reached your personal donation limit of $2500 for this election. Call '.PHONE_NUMBER.' if you feel this is incorrect, or if you\'d like to discuss other ways to help out our campaign!';
        } else {
            // Submit the payment and charge the card.
            try {
                Stripe::setApiKey($secretKey);
                $charge = Stripe_Charge::create($params);

                // Charge was successful. Fill in response details.
                $response['success']        = true;
                $response['id']             = $charge->id;
                $response['amount']         = number_format($charge->amount/100, 2);
                $response['fee']            = number_format($charge->fee/100, 2);
                $response['card_type']      = $charge->card->type;
                $response['card_last4']     = $charge->card->last4;
                $response['meta']           = $meta;
                $response['desc']           = $params['description'];
            } catch (Exception $e) {
                $response['error'] = $e->getMessage();
            }
        }
    }

    // Add additional processing here
    if($response['success']) {
        // Succeess

        // Now let's hit Ella.
        $meta['transaction_id'] = $response['id'];
        $meta['fee'] = $response['fee'];
        $meta['card_type'] = $response['card_type'];
        $meta['card_last4'] = $response['card_last4'];
        if($_POST['ask'] && !empty($_POST['ask'])) $meta['ask'] = $_POST['ask'];
        if($_POST['tags'] && !empty($_POST['tags'])) $meta['tag'] = $_POST['tags'];

        // OAuth and send payment info to PUT https://sync.revmsg.net/payment


    } else {
        // Failed
        // Log?
    }

    // Serialize the response back as JSON
    if(isset($response['fee'])) unset($response['fee']);
    if(isset($response['card_type'])) unset($response['card_type']);
    if(isset($response['card_last4'])) unset($response['card_last4']);
    if(isset($response['meta'])) unset($response['meta']);
    if(isset($response['desc'])) unset($response['desc']);
    echo json_encode($response);
    die();
}

function array_implode ($glue, $separator, $array) {
    if( ! is_array($array) ) {
        return $array;
    }
    $string = array();
    foreach( $array as $key => $val ) {
        if( is_array( $val )) {
            $val = implode(",", $val);
        }
        $string[] = "{$key}{$glue}{$val}";
    }
    return implode($separator, $string);
}

?>