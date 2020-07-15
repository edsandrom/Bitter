<?php
include("connect.php");
include("Includes/header.php");
?>
<!DOCTYPE html>
<!--Using the same registration template as base-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Contact us, the Bitter support team">
        <meta name="author" content="Edsandro M. de Oliveira / edsandrom@gmail.com">
        <link rel="icon" href="favicon.ico">

        <title>Contact Us - Bitter</title>

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



        <BR><BR>
        <div class="container">
            <div class="row">

                <div class="main-login main-center"> <!--Using the same class to keep the pattern-->
                    <h5>Reach us:</h5>
                    <BR>
                    <form method="post" id="contact_form" action="">
                        <label for="name" class="cols-sm-2 control-label" >Name:</label>
                        <input id="name" type="text" name="name" size="50" required="required"/><br><br>
                        <label for="email" class="cols-sm-2 control-label">E-mail:</label>
                        <input id="email" type="email" name="email" size="50" required="required"/><br><br>
                        <label for="comments" class="cols-sm-2 control-label">Message:</label><br>
                        <textarea id="comments" name="comments" rows="10" cols="58" required="required"></textarea><br><br>
                        <div class="form-group ">
                            <input type="submit" name="submitButton" id="button" value="Send the message" class="btn btn-primary btn-lg btn-block login-button"/>
                        </div>

                    </form>
                </div>

            </div> 
        </div>
        <footer>
            <BR>
            <BR>
            <BR>
            <div class="main-login main-center">
                <h6>E-mail</h6>
                <a href="mailto:edsandrom@gmail.com"><img class="bannericons" src="images/email.png" alt="e-mail"></a> &nbsp;

                <a href="https://twitter.com/" target="_blank">(000) 123-4567</a> &nbsp;
                <br>
                <br>
            </div>
            <div align="center">Copyright &copy; Bitter</div>

        </footer>
    </body>
</html>