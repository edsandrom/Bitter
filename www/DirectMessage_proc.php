<?php

include("Includes/User.php");
include("connect.php");
date_default_timezone_set('America/Halifax'); //Setting Timezone
session_start();
if (isset($_POST['message']) && isset($_POST['to'])) {
    $mainUser = new User();
    $mainUser = $mainUser->setAll($_SESSION['SESS_MEMBER_ID'], $con);
    if (User::getUserByScreenName($_POST['to'], $con) == null) {
        $msg = "User not found.";
        Header("location:DirectMessage.php?msg=$msg");
    } else {
        $toUser = User::getUserByScreenName($_POST['to'], $con);

        User::addMessage($mainUser->getUserId(), $toUser->getUserId(), $con);
    }
}
?>

