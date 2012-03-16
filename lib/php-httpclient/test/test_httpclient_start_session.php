<?php

session_start();

echo "Slipped you a cookie...";

$_SESSION['test'] = 'You have a cookie! Session is active...';

?>