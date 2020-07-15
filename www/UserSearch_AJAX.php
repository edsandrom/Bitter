<?php

include("connect.php");
include("Includes/User.php");
if (isset($_POST['to'])) {
    $to = ($_POST['to']);
    $rs = User::getUsers($to, $con);
    while ($result = mysqli_fetch_assoc($rs)) {
        $users = json_encode($result);
    }
    echo $users;
}
?>

