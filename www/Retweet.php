<?php

include("connect.php");
include("Includes/User.php");
include("Includes/Tweet.php");

session_start();
if (isset($_SESSION['SESS_MEMBER_ID'])) {
    if (isset($_GET["tweetId"])) {
        $tweet = new Tweet();
        $newUser = new User();
        $retweet = new Tweet();
        $tweet->setTweetId($_GET["tweetId"]);
        $newUser->setUserId($_SESSION['SESS_MEMBER_ID']);
        Tweet::retweet($tweet->getTweetId(), $newUser->getUserId(), $con);
    }
}
?>
