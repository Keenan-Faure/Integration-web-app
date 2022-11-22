<?php

session_start(); 
include("../createConnection.php");
use Connection\Connection as connect;

$connection2 = new connect();
if(isset($_SESSION['connection']))
{
    $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $query2 = 'SELECT SKU FROM Inventory WHERE Active = "true"';
    $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
    $result = $output2->result;
    $variable = new \stdClass();
    $variable->return = true;
    $variable->body = $result;
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