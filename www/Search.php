<?php
include("connect.php");
include("Includes/header.php");
date_default_timezone_set('America/Halifax'); //Setting Timezone

if (isset($_POST['searchInput'])) {
    $mainUser = new User();
    $mainUser->setUserId($_SESSION['SESS_MEMBER_ID']);
    $word = $_POST['searchInput'];
    $rs = User::searchUsers($word, $con);
    $twRS = Tweet::searchTweets($word, $con);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Edsandro M. de Oliveira / edsandrom@gmail.com">
        <meta name="description" content="Search and find">
        <link rel="icon" href="favicon.ico">
        <title>Search</title>
        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

        <script src="includes/bootstrap.min.js"></script>

        <script type="text/javascript">
            //any JS validation you write can go here
        </script>
    </head>

    <body>
        <BR>
        <h1 style="text-align: center;">Users Found:</h1>
        <div class="bold" style="text-align: center;">
            <?php
            while ($result = mysqli_fetch_array($rs)) {
                $dispUser = new User();
                $dispUser->setUserId($result['user_id']);
                $dispUser->setFirstName($result['first_name']);
                $dispUser->setLastName($result['last_name']);
                $dispUser->setUserName($result['screen_name']);
                echo '<BR>';
                echo '<a href = "userpage.php?user_id=' . $dispUser->getUserId() . '">' . $dispUser->getFirstName() . " " . $dispUser->getLastName() . " @" . $dispUser->getUserName() . '</a><BR>';
                User::userFollowsAnother($mainUser->getUserId(), $dispUser->getUserId(), $con);
                echo '<BR>';
                User::anotherFollowsUser($mainUser->getUserId(), $dispUser->getUserId(), $con);
                echo '<BR>';
                echo '<hr></hr>';
            }
            ?>
        </div>
        <BR><BR>
        <h1 style="text-align: center;">Tweets Found:</h1>
        <?php
        while ($row = mysqli_fetch_array($twRS)) {
            $tweet = new Tweet();
            $tweet->setTweetId($row['tweet_id']);
            Tweet::tweetSearchDisplayTweets($tweet->getTweetId(), $con);
            echo '<BR>';
        }
        ?>
    </body>
</html>