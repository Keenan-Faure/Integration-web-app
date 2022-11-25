<?php

session_start(); 
include("../Class Templates/createConnection.php");
use Connection\Connection as connect;

//create URL to distinguish between the two Connectors
$connection2 = new connect();

$host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
$fullUrl = $_SERVER["REQUEST_URI"];
$fullUrl = $host . $fullUrl;
$connector = ($connection2->queryParams($fullUrl))['q'];

if(isset($_SESSION['connection']))
{
    if($connector == 'woo')
    {
        $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $query2 = 'SELECT inv.SKU FROM Inventory inv INNER JOIN Woocommerce woo ON inv.SKU = woo.SKU WHERE inv.Audit_Date > woo.pushDate';
        $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $result = $output2->result;
        $variable = new \stdClass();
        $variable->return = true;
        $variable->body = $result;
        echo(json_encode($variable));
    }
    else if($connector == 's2s')
    {
        $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $query2 = 'SELECT inv.SKU FROM Inventory inv INNER JOIN Stock2Shop s2s ON inv.SKU = s2s.SKU WHERE inv.Audit_Date > s2s.pushDate';
        $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $result = $output2->result;
        $variable = new \stdClass();
        $variable->return = true;
        $variable->body = $result;
        echo(json_encode($variable));
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