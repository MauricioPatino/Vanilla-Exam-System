<?php
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);
//https://web.njit.edu/~mjb88/mid_autograder.php
//https://web.njit.edu/~mjb88/mid_proxy.php
if ($data["requestType"]=='autograder') {
  $url = "https://web.njit.edu/~mp924/onlineexam/mid_autograder.php";
} else {
  $url = "https://web.njit.edu/~mp924/onlineexam/mid_proxy.php";
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