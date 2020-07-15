<?php include("connect.php");
include("Includes/User.php");?>
<?php

session_start();
if (isset($_POST["photoSubmit"])) {
    $user = new User();
    $user->setUserId($_SESSION['SESS_MEMBER_ID']);
    User::editPhoto($user->getUserId(), $con);
}
?>