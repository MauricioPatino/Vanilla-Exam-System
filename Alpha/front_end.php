<?php
$username = $_POST['username'];
$password = $_POST['password'];

$url = "https://web.njit.edu/~mjb88/middle_end.php";
$postData = array(
  'username' => $username,
  'password'  => $password
);

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS , $postData);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($handle);
curl_close($handle);
echo $json;
?>