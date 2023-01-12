<?php

session_start();
$_SESSION['woo_push_status'] = new \stdClass();

include("cURL.php");
include("../Class Templates/createConnection.php");
include("../Class Templates/utility.php");
$_woo_settings = $_SESSION['woo_settings'];

use Connection\Connection as connect;
use cURL\CURL as curl;
use utils\Utility as util;

$connection = new connect();
$util = new util();
$curl = new curl();

if(isset($_SESSION['connection']))
{
    if($_SESSION['connection']->active == true)
    {
        $products = get_prod_woo($connection);
        push_woo($products, $connection, $util, $curl, $_woo_settings);
    }
}
else
{
    $_SESSION['woo_push_status']->return = false;
    $_SESSION['woo_push_status']->message = 'No Session found';
}

/**
 * Queries the data to return all the products that are elligible to push to Stock2Shop
 */
function get_prod_woo($connection)
{
    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $query2 = 'SELECT inv.SKU FROM Inventory inv INNER JOIN Woocommerce woo ON inv.SKU = woo.SKU WHERE inv.Audit_Date > woo.pushDate AND Active = "true" LIMIT 5';
    $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);

    $result = $output2->result;
    return $result;
}

function push_woo($products, $connection, $util, $curl, $_woo_settings)
{
    $_SESSION['woo_push_status']->return = true;
    $_SESSION['woo_push_status']->message = 'Push was Initialized';
    echo(json_encode($_SESSION['woo_push_status']));

    $limit = sizeof($products);
    if($limit == 0)
    {
        $_SESSION['woo_push_status']->return = true;
        $_SESSION['woo_push_status']->message = 'Push Complete';
        exit();
    }
    for($i = 0; $i < $limit; ++$i)
    {
        $_SESSION['woo_push_status']->message = "Pushing Product " . ($i+1) . "/" . $limit;

        $sku = $products[$i]->SKU;
        if($sku == '')
        {
            $_SESSION['woo_push_status']->return = true;
            $_SESSION['woo_push_status']->message = 'Null SKU cannot be pushed';
            exit();
        }

        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $arrayData = ($connection->converterObject($rawConnection, 'SELECT * FROM Inventory WHERE SKU = "' . $sku . '"')->result);
        $arrayData[0]->Description = html_entity_decode($arrayData[0]->Description);

        $found = $curl->check_woo_sku($sku);
        
        if($found->result == 'true')
        {
            //exists
            $curl->woo_addProduct($arrayData[0], $_woo_settings, true, $connection);
        }
        else if($found->result == 'false')
        {
            //do not exist
            //creates new products on Woocommerce
            $curl->woo_addProduct($arrayData[0], $_woo_settings, false, $connection);
        }
        else if($found->result == 'null')
        {
            $_SESSION['woo_push_status']->return = false;
            $_SESSION['woo_push_status']->message = $found->message;
            exit();
        }
    }
    $_SESSION['woo_push_status']->return = true;
    $_SESSION['woo_push_status']->message = 'Push Complete';
    exit();
}
?>