<?php

session_start();
session_unset();
session_destroy();

// go to the logout page
header("location: login.php");
exit;

?>