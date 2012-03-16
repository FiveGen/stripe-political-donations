<?php

session_start();

echo "Session contents: " . @$_SESSION['test'];

?>