<?php
include("connect.php");
include("Includes/Header.php");
?>
<?php
if (isset($_SESSION['SESS_MEMBER_ID'])) {
    if (isset($_GET["tweetId"]) AND ( isset($_POST['reply']))) {
        if (!empty($_POST['myReply'])) {
            $tweet = new Tweet();
            $newUser = new User();
            $reply = new Tweet();
            $tweet->setTweetId($_GET["tweetId"]);
            $reply->setReplytoTweetId($tweet->getTweetId());
            $reply->setTweetText(addslashes($_POST['myReply']));
            $newUser->setUserId($_SESSION['SESS_MEMBER_ID']);
            $reply->setUserId($newUser->getUserId());
            Tweet::replyTweet($tweet->getTweetId(), $reply->getUserId(), $reply->getTweetText(), $reply->getReplytoTweetId(), $con);
        }
    } else {
        $msg = "You need to reply something.";
        echo "<script>alert('$msg');</script>";
    }
} else {
    $msg = "You need to be logged in to reply.";
    header("location:login.php?msg=$msg");
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

        <script>
            //just a little jquery to make the textbox appear/disappear like the real Twitter website does
            $(document).ready(function () {
                //hide the submit button on page load
                $("#button").hide();
                $("#reply_form").submit(function () {

                    $("#button").hide();
                });
                $("#myReply").click(function () {
                    this.attributes["rows"].nodeValue = 5;
                    $("#button").show();

                });//end of click event
                $("#myReply").blur(function () {
                    this.attributes["rows"].nodeValue = 1;
                    //$("#button").hide();

                });//end of click event
            });//end of ready event handler

        </script>
    </head>
    <body>
        <BR><BR>
        <div class="col-md-6">
            <div class="img-rounded">
                <form method="post" id="reply_form" action="">
                    <div class="form-group">
                        <textarea class="form-control" name="myReply" id="myReply" rows="1" placeholder="Reply!"></textarea>
                        <input type="submit" name="reply" id="reply" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
                        <BR><BR>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
