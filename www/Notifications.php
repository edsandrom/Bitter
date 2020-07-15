<?php
//this is the main page for our Bitter website, 
//it will display all tweets from those we are trolling
//as well as recommend people we should be trolling.
//you can also post a tweet from here
include("connect.php");
include("Includes/Header.php");
date_default_timezone_set('America/Halifax'); //Setting Timezone
if (isset($_SESSION['SESS_MEMBER_ID'])) {
    $mainUser = new User();
    $mainUser->setFirstName($_SESSION['SESS_FIRST_NAME']);
    $mainUser->setLastName($_SESSION['SESS_LAST_NAME']);
    $mainUser->setUserId($_SESSION['SESS_MEMBER_ID']);
    $mainUser->setAll($mainUser->getUserId(), $con);
    $rtOrig = new Tweet();
    $rtUser = new User();
    
    if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
        echo "<script>alert('$msg');</script>";
//        Header("refresh:0.001;url=index.php"); //Removes the $msg from url //Cannot refresh the page after an echo
    }
} else {
    Header("location:login.php");
}
?>
<?php
if (isset($_POST['reply'])) {
    $reply = new Tweet();
    $reply->setTweetText(addslashes($_POST['myReply']));
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Welcome to Bitter, the best anti-social media network of the century">
        <meta name="author" content="Edsandro M. de Oliveira / edsandrom@gmail.com">
        <link rel="icon" href="favicon.ico">

        <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
    </head>

    <body>
        <BR><BR>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="mainprofile img-rounded">
                        <div class="bold">
                            <img class="bannericons" src="images/profilepics/<?php echo $mainUser->getUserId() ?>">
                            <a href="userpage.php?user_id=<?php echo $mainUser->getUserId() ?>"><?php echo $mainUser->getFirstName() . " " . $mainUser->getLastName() ?> </a><BR></div>
                        <table>
                            <tr><td>
                                    tweets</td><td>following</td><td>followers</td></tr>
                            <tr>
                                <td><?php echo $mainUser->countTweets($mainUser->getUserId(), $con); ?></td>
                                <td><?php echo $mainUser->countFollowing($mainUser->getUserId(), $con); ?></td>
                                <td><?php echo $mainUser->countFollowed($mainUser->getUserId(), $con); ?></td>
                            </tr>
                        </table>
                        <BR><BR><BR><BR><BR>
                    </div><BR><BR>
                    <div class="trending img-rounded">
                        <div class="bold" style="padding-left:5%;">Trending</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="img-rounded">
                        <!--display list of tweets here-->
                        <BR><BR>
                        <?php
                        User::notificationsPageDisplayInfo($mainUser->getUserId(), $con);
                        ?> 
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bold">Who to Troll?<BR></div>
                    <div class="row2">
                        <?php
                        User::displayTop3($mainUser->getUserId(), $con);
                        ?>
                    </div>
                </div><BR>
            </div>

        </div>
        <!--don't need this div for now 
                    <div class="trending img-rounded">
                    © 2019 Bitter
                    </div>-->
    </div> <!-- end row -->
</div><!-- /.container -->



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="includes/bootstrap.min.js"></script>

</body>
</html>
