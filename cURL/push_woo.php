<?php

session_start();
include('cURL.php');
include("../Class Templates/createConnection.php");
use Connection\Connection as connect;
use cURL\CURL as curl;

//Runs one at a time - per SKU
if(isset($_SESSION['connection']))
{
    if($_SESSION['connection']->active == true)
    {
        $curl = new curl();
        $connection = new connect();

        //credentials
        $_woo_settings = $_SESSION['woo_settings'];

        //creates array of products to push
        //gets data from Inventory for that one product
        $host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
        $fullUrl = $_SERVER["REQUEST_URI"];
        $fullUrl = $host . $fullUrl;
        $sku = ($connection->queryParams($fullUrl));
        if($sku == false)
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->message = 'No Param was entered';
            echo(json_encode($variable));
            exit();
        }
        $sku = $sku['sku'];
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        if($sku == '')
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->message = 'Attempting to query NULL SKU';
            echo(json_encode($variable));
            exit();
        }
        $arrayData = ($connection->converterObject($rawConnection, 'SELECT * FROM Inventory WHERE SKU="' . $sku . '"')->result);
        $arrayData[0]->Description = html_entity_decode($arrayData[0]->Description);
        $sku = $arrayData[0]->SKU;
        $found = $curl->check_woo_sku($sku);
        if($found->result == 'true')
        {
            //exists
            //gets settings from php file
            $wooSettings = $_SESSION['woo_settings'];
            echo(json_encode($curl->woo_addProduct($arrayData[0], $wooSettings, true, $connection)));
        }
        else if($found->result == 'false')
        {
            //do not exist
            //gets settings from php file
            $wooSettings = $_SESSION['woo_settings'];
            
            //creates new products on Woocommerce
            echo(json_encode($curl->woo_addProduct($arrayData[0], $wooSettings, false, $connection)));
        }
        else if($found->result == 'null')
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->message = $found->message;
            echo(json_encode($variable));
            exit();
        }
    }
}
else
{
    $conn = new connect();
    $conn->createHtmlMessages('', 'No Login details found in current session', 'Please relog', 'login', false);
}

?>