<?php

include "test.config.php";
if (!defined("TEST_HOST")) { readfile('README.txt'); die(); }
require_once "../HttpClient.class.php";

?>
<html>

<head><title>HttpClient Test Page</title></head>

<body>

<h1>HttpClient Test Page</h1>

<h2>Test #1: Follow redirects</h2>

<p>In this test, we check to see if HttpClient can follow redirects correctly.</p>

<?php

$client = new HttpClient('scripts.incutio.com');

$client->setDebug(true);

if (!$client->get('/httpclient')) {
	echo '<p>Request failed!</p>';
} else {
	echo '<p>Request succeeded.</p>';
}

unset($client);

?>

<h2>Test #2: Getting gzipped content</h2>

<p>In this test, we check if HttpClient is capable of properly decoding a gzipped response.</p>

<?php

$client = new HttpClient('www.amazon.com');

$client->setDebug(true);

if (!$client->get('/')) {
	echo '<p>Request failed!</p>';
} else {
	echo '<p>Amazon home page is '.strlen($client->getContent()).' bytes (unzipped).</p>';
}

unset($client);

?>

<h2>Test #3: Persistent cookies</h2>

<p>In this test, we use cookie persistence to start a session with a server - this server will store a session-variable, locally, on the server. We then send a second request, which should include the session id, which the server returned in the first request, and this script should then be able to retrieve the value of the session-variable it stored during the first request.</p>

<p>If this test works, you should see the following text in <span style="color:#0a0">green</span> in the output below: <em>"Session check returned: Session contents: You have a cookie! Session is active..."</em>.</p>

<h3>Starting a session...</h3>

<?php

$client = new HttpClient(TEST_HOST);

$client->setDebug(true);

if (!$client->get(TEST_PATH.'/test_httpclient_start_session.php')) {
	echo '<p>Request failed!</p>';
} else {
	echo '<p>Session started...</p>';
}

echo "<h3>Checking if session is active...</h3>";

if (!$client->get(TEST_PATH.'/test_httpclient_check_session.php')) {
	echo '<p>Request failed!</p>';
} else {
	echo '<p>Session check returned: <span style="color:#0a0">' . $client->getContent() . '</span></p>';
}

unset($client);

?>

<h2>Test #4: Custom cookies</h2>

<p>In this test, we submit a custom cookie - the script then returns the value of the cookies in it's output.</p>

<p>If this works out, you should see the following in <span style="color:#0a0">green</span> in the output below: <em>Your cookies: 'OVERWRITE_ME' = 'This value has been overwritten', 'ANOTHER_COOKIE' = 'And so was this.', 'TEST_COOKIE' = 'This cookie was set using the setCookies() method...'</em></p>

<?php

$client = new HttpClient(TEST_HOST);

$client->setDebug(true);

$client->setCookies(array("REPLACE_ME" => "This cookie will be overwritten by the next call to setCookies()"));

$client->setCookies(array(
	"OVERWRITE_ME" => "This should be overwritten",
	"TEST_COOKIE" => "This cookie was set using the setCookies() method..."
), true);

$client->setCookies(array(
	"OVERWRITE_ME" => "This value has been overwritten",
	"ANOTHER_COOKIE" => "And so was this."
)); // this should NOT overwrite the existing value of TEST_COOKIE.

if (!$client->get(TEST_PATH.'/test_httpclient_dump_cookies.php')) {
	echo '<p>Request failed!</p>';
} else {
	echo '<p>Cookie test returned: <span style="color:#0a0">' . $client->getContent() . '</span></p>';
}

unset($client);

?>

<h2>Test #5: quickGet() and string-magic</h2>

<p>You should see the HTML source code returned by a Google search query below.</p>

<?php

echo "<textarea cols=\"120\" rows=\"20\">";
echo htmlspecialchars( HttpClient::quickGet('http://www.google.com/search?source=ig&hl=en&rlz=&q=php+httpclient&btnG=Google+Search') );
echo "</textarea>";

echo "<p>You should see the same HTML source code again below, but this time the HttpClient class constructs the query arguments from an associative array.</p>";

$vars = array(
	"source" => "ig",
	"hl"     => "en",
	"rlz"    => "",
	"q"      => "php httpclient",
	"btnG"   => "Google Search"
);

echo "<textarea cols=\"120\" rows=\"20\">";
echo htmlspecialchars( HttpClient::quickGet('http://www.google.com/search', $vars) );
echo "</textarea>";

?>

<h1>End of tests.</h1>

</body>

</html>
