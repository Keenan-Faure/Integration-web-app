<?php

namespace vProducts;
include('createConnection.php');

use Connection\Connection as connect;

Class vProducts
{
    private $title;
    private $description;
    private $category;
    private $productType;
    private $brand;
    private $sku;
    private $groupingCode;
    private $variantCode;
    private $barcode;
    private $weight;

    private $costPrice;
    private $sellingPrice;

    private $whseName;
    private $quantity;

    private $optionName;
    private $optionValue;
    private $option2Name;
    private $option2Value;

    private $meta1;
    private $meta2;
    private $meta3;

    private $product;

    function createProduct($product, $util)
    {
        //checks if all the numeric values entered are numeric...
        $numeric = array("barcode", "weight", "costPrice", "sellingPrice", "quantity"); //array of numeric values
        for($j = 0; $j < sizeof($numeric); ++$j)
        {
            if(isset($product[$numeric[$j]]))
            {
                if($product[$numeric[$j]] != null)
                {
                    //check if they are numeric using the util class -- its a parameter
                    $variable = $util->isNumeric($product[$numeric[$j]], $numeric[$j]);
                    if($variable->result == false)
                    {
                        // returns the values that are not numeric...
                        return $variable;
                    }
                }
            }
        }

        //query against Database to check if the options, SKU, source variant codes are repeated?_?

        //create connection first
        $connection = new connect();
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        //checks SKU
        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;

        //checks SKU
        if($util->existSKU($product, $rawConnection, $connection) !== true)
        {
            return $util->existSKU($product, $rawConnection, $connection);
        }

        if($util->existVariantCode($product, $rawConnection, $connection) !== true)
        {
            return $util->existVariantCode($product, $rawConnection, $connection);
        }
        if($util->existOptions($product, $rawConnection, $connection) !== true)
        {
            return $util->existOptions($product, $rawConnection, $connection);
        }




        //creates the product
        $productTemplate = array('title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'costPrice', 'sellingPrice',
        'whseName', 'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3');

        //creates as a standard class
        $this->product = new \stdClass();
        for($i = 0; $i < sizeof($productTemplate); ++$i)
        {
            //for debugging only 

            //print_r($product[$productTemplate[$i]]);
            //echo("<br>");
            if(isset($product[$productTemplate[$i]]))
            {
                //converts to a string
                $variable = json_encode($productTemplate);
                $this->product->$variable[$i] = $product[$productTemplate[$i]];
            }
        }
    }
}
?>

