<?php
//this page will allow the user to edit their profile photo
include("connect.php");
include("Includes/header.php");
if (!isset($_SESSION['SESS_MEMBER_ID'])) {//Check if users are logged in before allow them to edit profile picture
    $msg = "You need to be logged in.";
    Header("location:login.php?msg=$msg");
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Who are you? Identify yourself and enjoy Bitter features">
        <meta name="author" content="Edsandro M. de Oliveira / edsandrom@gmail.com">
        <link rel="icon" href="favicon.ico">

        <title>Upload Photo - Bitter</title>
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
        <form method="post" id="photo_form" action="edit_photo_proc.php" enctype="multipart/form-data">
            <input type="file" name="photoUpload" accept="image/*">
            <input type="submit" value="Submit Picture" name="photoSubmit">
        </form>
    </body>
</html>