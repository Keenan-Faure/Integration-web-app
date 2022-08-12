<?php

namespace cURL;
Class CURL
{
    
    private $username='root';
    private $password='';
    
    function geturl()
    {
        $host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
        $url = explode('/', $_SERVER['REQUEST_URI']); //needs to be defined
        $baseurl = $host;
        $delimiter = '/';
        for($i = 0; $i < sizeof($url); ++ $i)
        {
            if($url[$i] == 'MySQL-API')
            {
                return $baseurl;
            }
            else
            {
                if($i == 0)
                {
                    $baseurl = $baseurl . $url[$i];
                }
                else
                {
                    $baseurl = $baseurl . $delimiter . $url[$i];
                }
            }
        }
    }
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
    function cURLRequest($page, $request)
    {
        $page = geturl() . "/MySQL-API/API/v1.php";
        $response = get_web_page($page, $username, $password);
        $resArr = array();
        $resArr = json_decode($response);
        echo "<pre>"; print_r($resArr); echo "</pre>";
    }
}
?>