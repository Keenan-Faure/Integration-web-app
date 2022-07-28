<?php

$username = "Keenan";
$password = "kl";

$url = "http://192.168.64.3/MySQL-API/API/api.php";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password); 
$headers = array("Content-Type: application/json", '');
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$resp = curl_exec($curl);

curl_close($curl);
header("Content-type: application/json");
print_r($resp);

?>

