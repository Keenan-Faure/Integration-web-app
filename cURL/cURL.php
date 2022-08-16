<?php
namespace cURL;

Class CURL
{   
    function getUrl()
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
    function get_web_page($url, $request = null, $username, $password) 
    {
        $options = array(
            CURLOPT_USERPWD => $username . ":" . $password, 
            CURLOPT_HTTPHEADER => array("Content-Type: application/json", "accept: application/json"),
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "test", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        ); 
        
        $ch = curl_init($url);

        if(isset($request))
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        }

        curl_setopt_array($ch, $options);
        $content  = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //adds the HTTP code to check if errors were found
        $content = $this->addHTTP($content, $httpcode);
        curl_close($ch);
    
        return $content;
    }
    function getSources($token, $username, $password)
    {
        //use http_build_query here to create parameters for ep
        $params = http_build_query(array('format' => 'json', 'token' => $token)); 

        $url = 'https://app.stock2shop.com/v1/sources?' . $params;
        return $this->cURLRequest(null, $url, $username, $password);

    }
    function getChannels($token, $username, $password)
    {
        //use http_build_query here to create parameters for ep
        $params = http_build_query(array('format' => 'json', 'token' => $token)); 

        $url = 'https://app.stock2shop.com/v1/channels?' . $params;
        return $this->cURLRequest(null, $url, $username, $password);
    }

    function cURLRequest($request = new \stdClass(), $url, $username, $password)
    {
        $response = $this->get_web_page($url, $request, $username, $password);
        $resArr = array();
        $resArr = json_decode($response);
        return $resArr;
    }

    function validateToken($token, $username, $password)
    {
        $url = 'https://app.stock2shop.com/v1/users/valid_token/' . $token . '?format=json';
        return $this->cURLRequest(null, $url, $username, $password);
    }

    function authenticate($username, $password)
    {
        //builds json object
        $request = new \stdClass();
        $request->system_user_auth = new \stdClass();
        $request->system_user_auth->username = $username;
        $request->system_user_auth->password = $password;
        $request = json_encode($request);

        //url to send request
        $url = 'https://app.stock2shop.com/v1/users/authenticate?format=json';
        return $this->cURLRequest($request, $url, $username, $password);
    }
    function addHTTP($content, $code)
    {
        $content = json_decode($content);
        $content->httpcode = $code;

        $content = json_encode($content);
        return $content;
    }
}
?>