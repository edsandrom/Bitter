<?php
date_default_timezone_set('America/Halifax'); //Setting Timezone
//these are defined as constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bitter-edsandro');
//define('DB_NAME', 'productsdemo'); //Used for class - Don't use this one.

global $con;
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
?>
