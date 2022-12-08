<?php

session_start(); 
include("../Class Templates/createConnection.php");
use Connection\Connection as connect;

$connection2 = new connect();
if(isset($_SESSION['connection']))
{
    //gets SKU from URL
    $host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
    $fullUrl = $_SERVER["REQUEST_URI"];
    $fullUrl = $host . $fullUrl;
    $sku = ($connection2->queryParams($fullUrl))['q'];

    $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $query2 = 'SELECT Pushed FROM Stock2Shop WHERE SKU = "' . $sku . '"';
    $query3 = 'SELECT woo.P_ID, woo.ID, woo.SKU, inv.Audit_Date, inv.User FROM Woocommerce woo INNER JOIN Inventory inv ON inv.SKU = woo.SKU WHERE woo.SKU = "' . $sku . '"';
    $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
    $output3 = $connection2->converterObject($rawConnection, $query3, $_SESSION['connection']->credentials->dbname);

    if($output2 == null)
    {
        $output2 = 'null';
    }
    if($output3 == null)
    {
        $output3 = 'null';
    }
    $variable = new \stdClass();
    $variable->result = true;
    $variable->body = $output2;
    $variable->body_1 = $output3;
    echo(json_encode($variable));
}
else
{
    $variable = new \stdClass();
    $variable->result = false;
    $variable->body = "No session found";
    echo(json_encode($variable));
}


?>