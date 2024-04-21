<?php
	session_start();
	if (checklogin_mysql($_POST["username"],$_POST["password"])) {
?>
	<h2> Welcome <?php echo htmlentities($_POST['username']); ?> !</h2>
<?php
	}else{
		echo "<script>alert('Invalid username/password');window.location='form.php';</script>";
		die();
	}
	//function checklogin($username, $password) {
		//$account = array("admin","1234");
		//if (($username== $account[0]) and ($password == $account[1]))
		//return TRUE;
		//else
			//return FALSE;
	//}
	function checklogin_mysql($username,$password){

	$mysqli = new mysqli('localhost',
		'waph-team31', 
		'Pa$$w0rd'
		,'waph_team');
	if($mysqli->connect_errno){
		printf("Database connection failed: %s\n", $mysqli->connect_error);
		exit();
	}
	
	
	$prepared_sql = "SELECT * FROM users WHERE username= ?" . " AND password = md5(?);";
		  $stmt = $mysqli -> prepare($prepared_sql);
		  $stmt ->bind_param("ss", $username, $password);
		  $stmt ->execute();
		  $result= $stmt->get_result();
	//echo "DEBUG>sql= $sql"; //return TRUE;
	if($result->num_rows == 1)
		return TRUE;
	return FALSE;

	
	}
?>
<a href="logout.php">logout</a>

