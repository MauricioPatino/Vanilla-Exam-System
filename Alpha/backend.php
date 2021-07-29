<?php
  
	if(isset($_POST['username'])){
		$username = $_POST['username'];
	}
	if(isset($_POST['password'])){
		$password = $_POST['password'];
	}
	
  $conn = mysql_connect ("sql.njit.edu", "mp924", "Shaka.Juanes1");
  mysql_select_db ("mp924");
 
	$sql = "SELECT * FROM users WHERE username='$username';";
		
	// Grab the data from the select statement and insert into a result variable as raw data
	$result = mysql_query ($sql);
		
	// Check for results, assign it to a variable (associative array) to be used by php code 
	if($row = mysql_fetch_array($result)){
			// Database info
			$DbID = $row['ID'];
			$DbUser = $row['username'];
			$DbPass = $row['password'];
			$dbarray = array("ID" => $DbID, "User" => $DbUser);
			

			// Check and verify password from user input, and password from database
			$password = MD5($password);
			if($password !== $DbPass){
				echo '{result:"loginFailed"}';
				exit();
			}
			else if($password == $DbPass){
				// Start a session for that user and content on the page will change
				echo json_encode($dbarray);
				exit();
				
			}
			else{
				echo '{result:"loginFailed"}';
				exit();
			}			
	}
	else{
		echo '{result:"loginFailed"}';
		exit();
	}
	
  mysql_close($conn);


?>