<?php

session_start(); 
include("../createConnection.php");
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
    $query2 = 'SELECT woo.P_ID, woo.ID, woo.SKU, s2s.Pushed, inv.Audit_Date, inv.User FROM Woocommerce woo INNER JOIN Stock2Shop s2s ON s2s.SKU = woo.SKU INNER JOIN Inventory inv ON inv.SKU = woo.SKU WHERE woo.SKU = "' . $sku . '"';
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