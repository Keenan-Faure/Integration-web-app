<?php

$url = "http://localhost:3000";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array("Content-Type: application/json");
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$resp = curl_exec($curl);

curl_close($curl);
header("Content-type: application/json");
print_r($resp);

?>

