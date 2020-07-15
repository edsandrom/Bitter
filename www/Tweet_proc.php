<?php
include("connect.php");
include("Includes/User.php");
include("Includes/Tweet.php");
//insert a tweet into the database
if (isset($_POST['button'])) {
    session_start();
    $user = new User();
    $user->setUserId($_SESSION['SESS_MEMBER_ID']);
    $tweet = new Tweet();
    $tweet->setTweetText(addslashes($_POST['myTweet']));
    Tweet::tweet($tweet->getTweetText(), $user->getUserId(), $con);
}
?>