<?php

session_start();
include('cURL.php');
include("../createConnection.php");
use Connection\Connection as connect;
use cURL\CURL as curl;

if($_SESSION['connection']->active == true)
{
    $curl = new curl();
    $connection = new connect();

    //credentials
    $_woo_settings = $_SESSION['woo_settings'];

    //creates array of products to push
    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $arrayData = ($connection->converterObject($rawConnection, 'SELECT * FROM Inventory WHERE SKU = "GenImp-J-AS"')->result);
    $arrayData[0]->Description = html_entity_decode($arrayData[0]->Description);
    $message = 'Pushing Products... please wait';
    if(sizeof($arrayData) <= 0)
    {
        $message = 'No Products found to push';
    }
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

        print_r(json_encode($curl->woo_addProduct($arrayData[0], $wooSettings, true, $connection)));
        exit();

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
        print_r($curl->woo_addProduct($arrayData[0], $wooSettings, false, $connection));
        exit();
    }



    //decide whether to post or put the data depending on if the SKU is found in Woocommerce
    /*
    
    - Run script echo from php 
    - create recursive function to send updates to Woocommerce based on the number of
      products that are in the array
      - condition to check if n == 0
      - send update, if response is 200 (okay) then update page, increment total
      - if response if anything but 200, then add to logs and continue anyways
    - If it is done then return a completed page, update existing page using js

    */
}

?>