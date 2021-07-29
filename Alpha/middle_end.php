<?php
$username = $_POST['username'];
$password = $_POST['password'];

if (!isset($username) || !isset($password)) {
    exit(1);
}


// ---------------NJIT LOGIN SPOOFING ---------------------


$handle = curl_init();
$njit_url = "https://myhub.njit.edu/vrs/ldapAuthenticateServlet";

curl_setopt($handle, CURLOPT_POST, 1);
curl_setopt($handle, CURLOPT_POSTFIELDS,
            "user_name=" . urlencode($username) . "&passwd=" . urlencode($password) . "&SUBMIT=Login"
            );

curl_setopt($handle, CURLOPT_URL, $njit_url);
curl_setopt($handle, CURLOPT_HTTPHEADER, array(
'Content-Type: application/x-www-form-urlencoded'
)); 

curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

$html = curl_exec($handle);
curl_close($handle);

if (strpos($html, 'Invalid UCID/Password') !== false 
|| strpos($html, 'Please Enter UCID and Password') !== false) {
    $njit_login_success = false;
} else {
    $njit_login_success = true;
}


// --------------------DATABASE LOGIN -------------------------

$handle = curl_init();
$url = "https://web.njit.edu/~emo26/includes/login.php";
$postData = array(
   'username' => $username,
   'password'  => $password
);
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS , json_encode($postData));
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$backend_response = curl_exec($handle);
curl_close($handle);

if (strpos($backend_response, 'Logged in') !== false) {
    $db_login_success = true;
} else {
    $db_login_success = false;
}



// COMBINING RESULTS FROM NJIT LOGIN AND DATABASE LOGIN ------------------

$response = (object)array(
   'njit' => $njit_login_success,
   'db' => $db_login_success
);

$json = json_encode($response);
echo $json;
?>