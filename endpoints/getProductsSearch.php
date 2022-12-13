<?php

session_start(); 
include("../Class Templates/createConnection.php");
use Connection\Connection as connect;

//create URL to distinguish between the two Connectors
$connection2 = new connect();

$host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
$fullUrl = $_SERVER["REQUEST_URI"];
$fullUrl = $host . $fullUrl;
$params = ($connection2->queryParams($fullUrl));
$q = $params['q'];

if(isset($_SESSION['connection']))
{
    $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    /**
     * search based on:
     * collection
     * title
     * SKU
     */
    $query = 'SELECT Title, SKU, Group_Code, Brand FROM Inventory WHERE Category LIKE "%' . $q. '%" LIMIT 3';
    $output = $connection2->converterObject($rawConnection, $query, $_SESSION['connection']->credentials->dbname);
    $result = $output->result;

    $query1 = 'SELECT Title, SKU, Group_Code, Brand FROM Inventory WHERE Title LIKE "%' . $q. '%" LIMIT 3';
    $output1 = $connection2->converterObject($rawConnection, $query1, $_SESSION['connection']->credentials->dbname);
    $result1 = $output1->result;

    $query2 = 'SELECT Title, SKU, Group_Code, Brand FROM Inventory WHERE SKU LIKE "%' . $q. '%" LIMIT 3';
    $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
    $result2 = $output2->result;

    $variable = new \stdClass();
    $variable->return = true;
    $variable->body = $result;
    $variable->body_1 = $result1;
    $variable->body_2 = $result2;
    echo(json_encode($variable));
}
else
{
    $variable = new \stdClass();
    $variable->return = false;
    $variable->body = "No session found";
    echo(json_encode($variable));
}


?>