<?php
  require "database.php";
  
    session_set_cookie_params(15*60, "/","waph-team29.minifacebook.com",TRUE,TRUE);
    session_start();
  
    if (isset($_POST["username"]) and isset($_POST["password"])) {
        if (checklogin_mysql($_POST["username"],$_POST["password"])) {
            $_SESSION["authenticated"] = TRUE;
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["browser"] = $_SERVER['HTTP_USER_AGENT']; 
        }else{
            session_destroy();
            echo "<script>alert('Invalid username/password');window.location='form.php';</script>";
            die();
        }
    }
    if (!$_SESSION["authenticated"] or $_SESSION["authenticated"] != TRUE){
        session_destroy();
        echo "<script>alert('You have not login. Please login first');</script>";
        header("Refresh:0; url=form.php");
        die();
    }   
    if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
        session_destroy();
        echo "<script>alert('Session hijacking is detected!');</script>";
        header("Refresh:0; url=form.php");
        die();
    }           
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HomePage</title>
    
  </head>
  <body>
  	<div class="container wrapper">
<div id="top"><!-- put any top content between here -->
  <h1>WAPH-Individual Project</h1>
</div>
<div class="wrapper">

<div id="main">
  

   <h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>

    <button class="button" type="submit"><a href="changepasswordform.php"> Change password</a></button>| <button class="button" type="submit" name="edit"><a href="profile.php"> Edit profile</a></button>| <button class="button" type="submit"><a href="logout.php">Logout</a></button>
	<script src="index.js"></script>
	</center>
  </div>
  </div>
  </div>
  </body>
</html>
