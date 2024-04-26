<?php
 
 $lifetime=15*60;
 $path="/";
 $domain="waph-team31.minifacebook.com";
 $secure=TRUE;
 $httponly=TRUE;
 session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly); 

 session_start();  

 $_SESSION['superusername'] = $_POST['superusername'];
 $superusername=$_POST["superusername"];
 $superuserpassword=$_POST["superuserpassword"];

 if(isset($_POST["superusername"]) and isset($_POST["superuserpassword"])){

  if (checklogin_mysql($superusername,$superuserpassword)) {
    $_SESSION['authenticated']=TRUE;
    $_SESSION['username']= $_POST["username"];
    $_SESSION['browser']=$_SESSION['HTTP_USER_AGENT'];

  }else{
    session_destroy();
    echo "<script>alert('Invalid username/password');window.location='superuser.php';</script>";
    die();
  }
}

if(!isset($_SESSION['authenticated']) AND $_SESSION['authenticated'] !=TRUE){
  session_destroy();
  echo "<script>alert('You have not logged in. Please login again');</script>";
  header("location:/superuser.php"); 
  die();
}
if($_SESSION['browser'] !=$_SESSION['HTTP_USER_AGENT']){
  session_destroy();
  echo "<script>alert('Session hijacking attack is detected!');</script>";
  header("Refesh:0; url=adminLogin.php");
  die();

}

function checklogin_mysql($superusername, $superuserpassword) {
  $mysqli = new mysqli('localhost','waph-team31','Pa$$w0rd','waph_team' );
  if($mysqli->connect_errno){
   printf("DB connection failed",$mysqli->connect_error);
   exit();
 }

 $sql= "SELECT * FROM superusers WHERE superusername=? AND superuserpassword=md5(?)";
 $stmt=$mysqli->prepare($sql);
 $stmt->bind_param("ss",$superusername, $superuserpassword);
 $stmt->execute();
 $result=$stmt->get_result();

 if($result->num_rows ==1)
 {
        // Admin authenticated, set session variable
        $_SESSION['admin'] = $superusername;
        header("Location: admin.php");
        exit();
    } else {
        echo "Invalid username or password";
    }

}

?>