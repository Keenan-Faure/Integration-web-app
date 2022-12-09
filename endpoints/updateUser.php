<?php

session_start(); 
include("../Class Templates/createConnection.php");
use Connection\Connection as connect;

//create URL to distinguish between the two Connectors
$connection2 = new connect();

$host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
$fullUrl = $_SERVER["REQUEST_URI"];
$fullUrl = $host . $fullUrl;
$token = ($connection2->queryParams($fullUrl))['q'];

if(isset($_SESSION['connection']))
{

    //check if token is valid
    $query2 = 'SELECT * FROM Userz WHERE Token = "' . $token . '"';
    $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
    if($output2->result == null)
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found or invalid Token";
        echo(json_encode($variable));
        exit();
    }
    else
    {
        $query2 = 'SELECT * FROM Userz';
        $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $result = json_encode($output2->result);
        echo($result);
        exit();
    }
}
else
{
    $variable = new \stdClass();
    $variable->return = false;
    $variable->body = "No session found";
    echo(json_encode($variable));
}
?>