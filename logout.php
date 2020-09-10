<?php

//require('global.php');

session_destroy();

// Redirect to login page
header("location: index.php");

$_SESSION["uid"] = 0;
$_SESSION["usertype"] = 5;

?>