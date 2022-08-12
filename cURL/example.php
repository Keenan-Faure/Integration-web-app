<?php
$username='root';
$password='';
$page = "http://localhost/myWebsite/Websites/MySQL-API/API/v1.php";
$response = get_web_page($page, $username, $password);
$resArr = array();
$resArr = json_decode($response);
echo "<pre>"; print_r($resArr); echo "</pre>";

function get_web_page($url, $uname, $psw) 
{
    $options = array(
        CURLOPT_USERPWD => $uname . ":" . $psw, 
        CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
    ); 

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);

    return $content;
}

?>