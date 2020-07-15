<?php
session_start();
session_unset(); //Removes all variables from session
session_destroy(); //kills the session completely
Header("location:login.php");
//log the user out and redirect them back to the login page.
?>
