<?php
include("connect.php");
include("Includes/Header.php");
date_default_timezone_set('America/Halifax'); //Setting Timezone
if (isset($_SESSION['SESS_MEMBER_ID'])) {
    $mainUser = new User();
    $mainUser->setUserId($_SESSION['SESS_MEMBER_ID']);
    $mainUser = $mainUser->setAll($mainUser->getUserId(), $con);
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
        <script src="https://code.jquery.com/jquery-3.3.1.js" ></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
                    $(document).ready(function () {
        //hide the submit button on page load
                        $("#button").hide();
                        $("#message_form").submit(function () {
        //alert("submit form");
                            $("#button").hide();
                        });
                        $("#message").focus(function () {
                            this.attributes["rows"].nodeValue = 5;
                            $("#button").show();
                        });//end of click event
                        $("#to").keyup(//key up event for the user name textbox
                                function (e) {
                                    if (e.keyCode === 13) {
        //don't do anything if the user types the enter key, it might try to submit the form
                                        return false;
                                    }
                                    jQuery.get(
                                            "UserSearch_AJAX.php",
                                            $("#message_form").serializeArray(),
                                            function (data) {//anonymous function
        //uncomment this alert for debugging the directMessage_proc.php page
//        alert(data);
        //clear the users datalist
                                                $("#dlUsers").empty();
                                                if (typeof (data.users) === "undefined") {
                                                    $("#dlUsers").append("<option value='NO USERS FOUND' label='NO USERS FOUND'></option>");
                                                }
                                                $.each(data.users, function (index, element) {
        //this will loop through the JSON array of users and add them to the select box
                                                    $("#dlUsers").append("<option value='" + element.name + "' label='" + element.name + "'></option>");
//        alert(element.id + " " + element.name);
                                                });
                                            },
        //change this to "html" for debugging the UserSearch_AJAX.php page
                                            "json"
                                            );
        //make sure the focus stays on the textbox so the user can keep typing
                                    $("#to").focus();
                                    return false;
                                }
                        );
                    });//end of ready event handler
        </script>
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
                    <form method="post" id="message_form" action="DirectMessage_proc.php">
                        <div class="form-group">
                            Send message to: <input type="text" id="to" name="to" list="dlUsers" autocomplete="off"><br>
                            <datalist id="dlUsers">
                                <!-- this datalist is empty initially but will hold the list of users to select as the user is typing -->
                            </datalist>
                            <input type="hidden" name="userId" value="<?= $mainUser->getUserId() ?>">
                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="Enter your message here"></textarea>
                            <input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
                        </div>
                    </form>

                    <div class="img-rounded">
                        <!--display list of tweets here-->
                        <BR><BR>
                        <?php
                        User::getAllMessages($con, $mainUser->getUserId());
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
