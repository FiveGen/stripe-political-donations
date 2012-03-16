<?php

echo "Your cookies: ";

$cookies = array();

foreach ($_COOKIE as $index => $value) 
	$cookies[] = "'$index' = '$value'";

echo implode(", ", $cookies);

?>