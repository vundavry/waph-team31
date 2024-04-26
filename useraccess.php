<?php
$lifetime=15*60;
$path="/";
$domain="waph-team31.minifacebook.com";
$secure=TRUE;
$httponly=TRUE;
session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly); 
session_start();   
$mysqli = new mysqli('localhost','waph-team31','Pa$$w0rd' ,'waph_team' );
if($mysqli->connect_errno){
  printf("DB connection failed",$mysqli->connect_error);
  exit();
}     

$username = $_POST['username'];
$status=$_POST['status'];
$status=($status=='enable')? 'enable': 'disable'; 
  $query = "UPDATE users SET status = ? WHERE username = ?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('ss', $status,$username);
   if ($stmt->execute()) {
        echo "Account status updated.! ";
        echo  htmlentities($_POST['status']); 
   
    } else {
      echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
?>