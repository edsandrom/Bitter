<?php
        include("connect.php");
        include("Includes/header.php");
        if (isset($_SESSION['SESS_MEMBER_ID'])) {
            $msg = "You are already logged.";
            Header("location:index.php?msg=$msg");
            echo "<script>alert('$msg');</script>";
        } else if (isset($_GET["msg"])) {
            $msg = $_GET["msg"];
            echo "<script>alert('$msg');</script>";
            Header("refresh:0.001;url=login.php"); //Removes the $msg from url
        }
        ?>
<!DOCTYPE html>


<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Who are you? Identify yourself and enjoy Bitter features">
        <meta name="author" content="Edsandro M. de Oliveira / edsandrom@gmail.com">
        <link rel="icon" href="favicon.ico">

        <title>Login - Bitter</title>

        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

        <script src="includes/bootstrap.min.js"></script>


    </head>

    <body>

        

        <BR><BR>
        <div class="container">
            <div class="row">
                <div class="main-center  mainprofile">
                    <h1>Bitter</h1>
                    <p class="lead">Bitter - Social Media for Trolls, Narcissists, Bullies and United States Presidents.<br></p>
                </div>
                <div class="main-center  mainprofile">
                    <h1>Don't have a Bitter Account?</h1>
                    <p class="lead"><a href="signup.php">Click Here</a> to begin trolling your friends, family, politicians and celebrities.<br></p>
                </div>
                <div class="main-center  mainprofile">
                    <h5>Please Login Here!</h5>
                    <form method="post" id="login_form" action="login_proc.php">

                        <div class="form-group">
                            <label for="username" class="cols-sm-2 control-label">Screen Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" required name="username" id="username"  placeholder="Enter your Screen Name"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="cols-sm-2 control-label">Password</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="password" class="form-control" required name="password" id="password"  placeholder="Enter your Password"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <input type="submit" name="button" id="button" value="Login" class="btn btn-primary btn-lg btn-block login-button"/>

                        </div>

                    </form>
                </div>

            </div> <!-- end row -->
        </div><!-- /.container -->

    </body>
</html>