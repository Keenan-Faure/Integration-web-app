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
        $sku = $sku['q'];
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
        if($found == true)
        {
            //exists
            //gets settings from php file
            $wooSettings = $_SESSION['woo_settings'];
            $storeName = $wooSettings->Woocommerce_Store->store_name;
            $url = 'https://' . $storeName. '/wc-api/v3/products?filter[sku]=' . $sku;
            $ck = $wooSettings->Woocommerce_Store->consumer_key;
            $cs = $wooSettings->Woocommerce_Store->consumer_secret;

            echo(json_encode($curl->woo_addProduct($arrayData[0], $wooSettings, true, $connection)));
            /**
             * - Check if product exists on Woocommerce
             *      - Create product with mapping (internal/external)
             *      
             *      - Update product's general information
             *      - If it's a simple product then set the type to Simple 
             *          - Set the stock_management to false on global level
             *      
             *      - If the product is a simple product then update the variant level of the product
             *      - No Options because it's a simple product
             *      
             *      - If the product was a variable product then update the variant level of the product
             *      - Including options
             * 
             * - If it does not exist
             *      - Create product with mapping (internal/external)
             * 
             *      - Update product's general information
             *      - Simple product set type to Simple
             *          - Set the stock_management to false at global level
             *      
             *      - If the product is a simple product then add variant level (No Options)
             *  
             * 
             *      - If it's a variable product then update variants (add options)
             */
        }
        else
        {
            //do not exist
            //gets settings from php file
            $wooSettings = $_SESSION['woo_settings'];
            $storeName = $wooSettings->Woocommerce_Store->store_name;
            $url = 'https://' . $storeName. '/wc-api/v3/products?filter[sku]=' . $sku;
            $ck = $wooSettings->Woocommerce_Store->consumer_key;
            $cs = $wooSettings->Woocommerce_Store->consumer_secret;

            //creates new products on Woocommerce
            echo(json_encode($curl->woo_addProduct($arrayData[0], $wooSettings, false, $connection)));
        }
    }
}
else
{
    $conn = new connect();
    $conn->createHtmlMessages('', 'No Login details found in current session', 'Please relog', 'login', false);
}

?>