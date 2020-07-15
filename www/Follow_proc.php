<?php include("connect.php"); ?>
<?php
include("Includes/User.php");
//this page will be used when the user clicks on the "follow" button for a particular user
//process the transaction and insert a record into the database, then redirect the user back
//to index.php
session_start();
if (isset($_POST['followButton'])) {
    $followedUser = new User();
    $followingUser = new User();
    $followedUser->setUserId($_POST['userID']);
    $followingUser->setUserId($_SESSION['SESS_MEMBER_ID']);
    User::followUser($followingUser->getUserId(), $followedUser->getUserId(), $con);
} else {
    $msg = "An unexpected error has occurred.";
}
?>