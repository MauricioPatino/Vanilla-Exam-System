<?php
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);

if ($data["requestType"]=='login') {
  $url = "http://mp924.mooo.com:3000/onlineexam/back_login.php";
} 
elseif ($data["requestType"]=='questions' || $data["requestType"]=='addQuestion' || $data["requestType"]=='deleteQuestion') {
  $url = "http://mp924.mooo.com:3000/onlineexam/back_questions.php";
}
elseif ($data["requestType"]=='exams' || $data["requestType"]=='addExam' || $data["requestType"]=='deleteExam') {
  $url = "http://mp924.mooo.com:3000/onlineexam/back_exams.php";
}
elseif ($data["requestType"]=='myResults' || $data["requestType"]=='pendingResults' || $data["requestType"]=='releaseResult'
 || $data["requestType"]=='deleteResult') {
  $url = "http://mp924.mooo.com:3000/onlineexam/back_results.php";
} 
else {
  echo '{"error":"unknown Request type"}'; 
}

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS , $json);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$return_json = curl_exec($handle);
curl_close($handle);
echo $return_json;
?>