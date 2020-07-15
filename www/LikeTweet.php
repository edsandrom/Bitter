<?php
date_default_timezone_set('America/Halifax'); //Setting Timezone
include("connect.php");
include("Includes/Tweet.php");
include("Includes/User.php");
?>
<?php
session_start();
if (isset($_GET['tweet_Id'])){ //The user came from userpage
$tweet = new Tweet();
$tweet->setTweetId($_GET['tweet_Id']);
$user = new User();
$user->setUserId($_SESSION['SESS_MEMBER_ID']);
$userpage= new User();
$userpage->setUserId($_GET['user_id']);
$liked = $tweet->likedTweet($con, $tweet->getTweetId(), $user->getUserId());
if ($liked == 1) {
    $tweet->insertLike($con, $tweet->getTweetId(), $user->getUserId());
} else {
    $tweet->removeLike($con, $tweet->getTweetId(), $user->getUserId());
}
Header("location:userpage.php?user_id=" . $userpage->getUserId()); //Return to userpage.php
}
else if (isset(($_GET['tweetId']))){ //User came from index
$tweet = new Tweet();
$tweet->setTweetId($_GET['tweetId']);
$user = new User();
$user->setUserId($_SESSION['SESS_MEMBER_ID']);
$liked = $tweet->likedTweet($con, $tweet->getTweetId(), $user->getUserId());
if ($liked == 1) {
    $tweet->insertLike($con, $tweet->getTweetId(), $user->getUserId());
} else {
    $tweet->removeLike($con, $tweet->getTweetId(), $user->getUserId());
}
Header("location:index.php"); //Return to index.php
}

?>

