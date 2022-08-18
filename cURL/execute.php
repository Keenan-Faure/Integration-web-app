<?php
session_start();
include('cURL.php');
include("../createConnection.php");
use Connection\Connection as connect;
use cURL\CURL as curl;

//make condition statements for the various routes

if($_SESSION['connection']->active == true)
{
    $curl = new curl();
    if($_POST['endpoint'] == 'authenticate')
    {
        //if success then do something
        $result = $curl->authenticate($_POST['username'], $_POST['password']);
        if($result->httpcode != '200' || isset($result->errors))
        {
            echo(json_encode($result));
            exit();
        }
        $_SESSION['token'] = $result->system_user->token;
        echo(json_encode($result));
    }
    else if($_POST['endpoint'] == 'validToken')
    {
        echo(json_encode($curl->validateToken($_SESSION['token'],'keenan.faure', 'Re_Ghoul')));
    }
    else if($_POST['endpoint'] == 'getSources')
    {
        echo(json_encode($curl->getSources($_SESSION['token'],'keenan.faure', 'Re_Ghoul')));
    }
    else if($_POST['endpoint'] == 'getChannels')
    {
        echo(json_encode($curl->getChannels($_SESSION['token'],'keenan.faure', 'Re_Ghoul')));
    }
    else if($_POST['endpoint'] == 'pushProducts')
    {
        $connection = new connect();
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        //creates query
        
        $query = "SELECT * FROM Inventory";

        $output = $connection->converterObject($rawConnection, $query);
        if(sizeof($output->result) == 0)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->error = "No products found in Database > Inventory table";
            $variable->message = "Cannot push null in Inventory table";
            echo(json_encode($variable));
            exit();
        }
        mysqli_close($rawConnection);

        //gets the source information, we'll only use the flatfile
        $sources = ($curl->getSources($_SESSION['token'],'keenan.faure', 'Re_Ghoul'));
        if($sources->httpcode == '200')
        {
            $pushed = new \stdClass();
            $pushed->system_products = array();
            for($i = 0; $i < sizeof($output->result); ++$i)
            {
                $data = $curl->addProduct($output->result[$i], $sources->system_sources[0]);
                if($data != null)
                {
                    array_push($pushed->system_products, $data);
                }
                else
                {
                    if(isset($_SESSION['log']))
                    {
                        $variable = new \stdClass();
                        $variable->result = false;
                        $variable->message = "Product with SKU " . $output->result[$i]->SKU . " was not processed";
                        $variable->data = $data;
                        array_push($_SESSION['log'], $variable);
                    }
                }
            }
            echo(json_encode($pushed));
        }
        else
        {
            json_encode($curl->getSources($_SESSION['token'],'keenan.faure', 'Re_Ghoul'));
            exit();
        }
    }
}
else
{
    $variable = new \stdClass();
    $variable->active = false;
    $variable->message = 'No connection found in current session, please re-connect';
    $variable->failedPage = 'execute.php';
    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
    echo(json_encode($variable));
}

//should check at post form already, if the credentials are valid
//$username = $_POST['username'];
//$password = $_POST['password'];

/*
$result = $curl->authenticate('keenan.faure', 'Re_Ghoul');

while($token == null)
{
    if($result->httpcode != '200' || isset($result->errors) || $token == null)
    {
        //if the token is not set -- the first time the program runs
        $result = $curl->authenticate('keenan.faure', 'Re_Ghoul');
        $token = $result->system_user->token;
    }
    //otherwise set the token -- decide to use $_SESSION or not
    else
    {
        $token = $result->system_user->token;
        //print_r($token);
    }
    //sleep($delay);
}
*/


//All Data here, username, password, token must come from $_SESSION variables stored inside the session -- consider again.

//print_r(json_encode($curl->getSources('PGADBZNS7GNUG4SVGZK1DBIW5COQZBK98DPY38SD','keenan.faure', 'Re_Ghoul')));
//print_r(json_encode($curl->authenticate('keenan.faure', 'Re_Ghoul')));
//print_r(json_encode($curl->validateToken('PGADBZNS7GNUG4SVGZK1DBIW5COQZBK98DPY38SD','keenan.faure', 'Re_Ghoul')));
//print_r(json_encode($curl->getChannels('PGADBZNS7GNUG4SVGZK1DBIW5COQZBK98DPY38SD','keenan.faure', 'Re_Ghoul')));
//

//make a condition based on the returned values httpcode and errors
//if httpcode is 200 and error is not defined and token is defined then proceed.
//else if error code is not 200 and errors is defined then display error, stop process.
?>