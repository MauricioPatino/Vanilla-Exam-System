<?php
$username = 'test';
$password = 'test';

$url = "https://web.njit.edu/~emo26/ALPHA/back_login.php";
$postData = array(
  'username' => $username,
  'password'  => $password
);

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS , json_encode($postData));
   

curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($handle);
curl_close($handle);
echo $json;
?>