<?php
require 'db.php';  
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);
if (isset($data["md5"])) {
  $md5 = $data["md5"];
} else {
  $md5 = MD5($data["password"]);
}
 
// mockup
/*
if ($data["username"]=="instructor" && $md5=="175cca0310b93021a7d3cfb3e4877ab6") {
  
  $dbarray = array("result" => "success", "md5" => $md5, "userType" => "instructor" );
  echo json_encode($dbarray);
  exit();
}
else if ($data["username"]=="student" && $md5=="cd73502828457d15655bbd7a63fb0bc8") {
  $dbarray = array("result" => "success", "md5" => $md5, "userType" => "student" );
  echo json_encode($dbarray);
  exit();
}
else {
  $result = array("result"=>"loginFailed");
  echo json_encode($result); // incorrect password
	exit();
}
*/

$sql = "SELECT * FROM users WHERE username=? AND md5=?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
	echo '{"result":"error","error":"failed to prep statement"}';
}
else{
	mysqli_stmt_bind_param($stmt, "ss", $data["username"], $md5);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);	
	// Check for results, assign it to a variable (associative array) to be used by php code 
	if($row = mysqli_fetch_assoc($result)){
		$row["result"]="success"; // UI is expecting json property 'result'='success'
		echo json_encode($row);
	} else {
		echo '{"result":"loginFailed"}';
	}
}
mysqli_close($conn);


?>