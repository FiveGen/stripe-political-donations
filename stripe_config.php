<?php
require_once( dirname(__FILE__) . 'stripe.php' );

echo "var stripePublishable='".$publicKey."';var isLiveKeys=".$isLive.";</script>\n";