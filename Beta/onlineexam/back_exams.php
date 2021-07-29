<?php
require 'db.php';  
require 'back_include.php';

// process request 
if ($data["requestType"]=="exams") {
		$sql = "SELECT * FROM exams ORDER BY id";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo '{"result":"error","error":"failed to prep statement"}';
		mysqli_close($conn);
		exit();
	}
	else{
		mysqli_stmt_execute($stmt);
		$rows = array();
		$result = mysqli_stmt_get_result($stmt);	
		while($row = mysqli_fetch_assoc($result)){
			$rows[] = $row;
		} 
	}
	$response = array(
		"exams"=>$rows,
		"result"=>"success",
		"debug"=>$json
	);
	echo json_encode($response);
  
}
elseif ($data["requestType"]=="addExam") {
	$sql = "INSERT INTO exams".
	"(name,questions,created) ".
	"values(?, ?, ?)";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo '{"result":"error","error":"failed to prep statement"}';
		mysqli_close($conn);
		exit();
	}
	else{
		$formData = $data["formData"];
	
		mysqli_stmt_bind_param($stmt, "sss", 
		$formData["name"], 
		$formData["questions"], 
		$formData["created"]);
		mysqli_stmt_execute($stmt);
	}
	$response = array(
		"result"=>"success",
		"debug"=>$json
	);
  echo json_encode($response);
} 
elseif ($data["requestType"]=="deleteExam") {
	$sql = "DELETE FROM exams".
	" WHERE id=?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo '{"result":"error","error":"failed to prep statement"}';
		mysqli_close($conn);
		exit();
	}
	else{
		$formData = $data["formData"];
	
		mysqli_stmt_bind_param($stmt, "i", $formData["exam_id"]);
		mysqli_stmt_execute($stmt);
	}
	$response = array(
		"result"=>"success",
		"debug"=>$json
	);
  echo json_encode($response);
} 
else {
  echo '{"error":"unknown Request type"}'; 
}

mysqli_close($conn);

?>