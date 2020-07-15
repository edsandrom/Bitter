<?php include("connect.php");
include("Includes/User.php");?>
<?php

//verify the user's login credentials. if they are valid redirect them to index.php/
//if they are invalid send them back to login.php
session_start();

if ((isset($_POST['username'])) and isset($_POST['password'])) {
    $_SESSION['username'] = $_POST['username'];
    $user = new User();
    $user->setUserName($_SESSION['username']);
    $_SESSION['password'] = $_POST['password'];
    $user->setPassword($_SESSION['password']);
    $user->checkLogin($user->getPassword(), $user->getUserName(), $con); //Using Method
}
?>