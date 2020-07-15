<?php
//displays all the details for a particular Bitter user
include("connect.php");
include("Includes/header.php");
date_default_timezone_set('America/Halifax'); //Setting Timezone
?>
<?php
if (isset($_GET['user_id'])) {
    $user = new User();
    $user->setUserId($_GET['user_id']);
    $user = $user->setAll($user->getUserId(), $con);
    $userDateFormated = Date("F dS Y", strtotime($user->getDateAdded()));
    $loggedUser = new User();
    $loggedUser->setUserId($_SESSION['SESS_MEMBER_ID']);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="I am not a joke. I am not a riddle! I am not a bird or a cat or a penguin! Here you can see an user data such as Tweets, Name, Username, Followers and more.">
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
                            <img class="bannericons" src="images/profilepics/<?php echo $user->getProfImage(); ?>">
                            <?php echo $user->getFirstName() . " " . $user->getLastName() ?></div>
                        <table>
                            <tr><td>
                                    tweets</td><td>following</td><td>followers</td></tr>
                            <tr><td><?php echo $user->countTweets($user->getUserId(), $con); ?></td>
                                <td><?php echo $user->countFollowing($user->getUserId(), $con); ?></td>
                                <td><?php echo $user->countFollowed($user->getUserId(), $con); ?></td>
                            </tr>
                        </table>
                        <img class="icon" src="images/location_icon.jpg"><?php echo $user->getLocation(); ?>
                        <div class="bold">Member Since:</div>
                        <div><?php echo $userDateFormated; ?></div>
                    </div>
                    <BR><BR>
                    <!---->
                    <!--list 3 followers that the user is also following-->
                    <?php
                    $recordSet = User::bothFollows($loggedUser->getUserId(), $user->getUserId(), $con);
                    $followedYouKnowRS = User::followedYouKnow($loggedUser->getUserId(), $user->getUserId(), $con); //Without limit of 3
                    $followersYouKnow = mysqli_num_rows($followedYouKnowRS);
                    ?>
                    <div class="trending img-rounded">
                        <div class="bold" style="padding-left:5%;"><?php echo $followersYouKnow ?> &nbsp;Followers you know<BR>
                            <?php
                            while ($mutual = mysqli_fetch_array($recordSet)) {
                                $dispUser = new User();
                                $dispUser->setUserId($mutual['user_id']); //User
                                $dispUser->setFirstName($mutual['first_name']); //User
                                $dispUser->setLastName($mutual['last_name']); //User
                                $dispUser->setUserName($mutual['screen_name']); //User
                                $dispUser->setProfImage($mutual['profile_pic']); //User
                                echo
                                '
                                    <div class="row" style= "padding-left:6%; padding-top:5%;">
                                            <img class="bannericons" src="images/profilepics/' . $dispUser->getProfImage() . '">
                                            <a href="userpage.php?user_id=' . $dispUser->getUserId() . '">' . $dispUser->getFirstName() . " " . $dispUser->getLastName() . " @" . $dispUser->getUserName() . '</a><BR>
                                                <div class="form-group">
                                                <hr></hr>
                                        </div>
                                    </div>
                            ';
                            }
                            ?>
                        </div>
                    </div>
                    <!--End of followers you know-->
                </div>
                <div class="col-md-6">
                    <div class="img-rounded">
                        <!--List all tweets from this user-->
                        <?php
                        User::userPageDisplayTweets($user->getUserId(), $con);
                        ?>
                        <BR><BR>
                        <!--End of tweets list-->
                    </div>
                    <div class="img-rounded">

                    </div>
                </div>
                <div class="col-md-3">
                        <div class="bold">Who to Troll?<BR></div>
                            <?php
                            User::displayTop3($loggedUser->getUserId(), $con);
                            ?>
                    </div><BR>
            </div> <!-- end row -->
        </div><!-- /.container -->



        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="includes/bootstrap.min.js"></script>

    </body>
</html>
