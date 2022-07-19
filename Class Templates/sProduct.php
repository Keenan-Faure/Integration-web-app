<?php

namespace sProducts;

use Connection\Connection as connect;

Class sProducts
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

    private $quantity;

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

        //query against Database to check if the options, SKU, source variant codes are repeated

        //create connection first
        $connection = new connect();
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;

        //checks SKU
        if($util->existSKU($product, $rawConnection, $connection) !== true)
        {
            return $util->existSKU($product, $rawConnection, $connection);
        }
        
        //checks variantCode
        if($util->existVariantCode($product, $rawConnection, $connection) !== true)
        {
            return $util->existVariantCode($product, $rawConnection, $connection);
        }

        //creates the product
        $productTemplate = array('title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'costPrice', 'sellingPrice',
        'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3');

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
                $variable = $productTemplate[$i];
                $this->product->$variable = $product[$productTemplate[$i]];
            }
        }
        return $this->product;
        
    }
    function addProduct($product)
    {
        $connection = new connect();
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;
        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;

        $query = "INSERT INTO Inventory 
        (
            Active,
            Title,
            Description,
            Category,
            Product_Type,
            Brand,
            SKU,
            Group_Code,
            Variant_Code,
            Barcode,
            Weight,
            CostPrice,
            SellingPrice,
            CapeTown_Warehouse,
            Meta_1,
            Meta_2,
            Meta_3
        )
        VALUES 
        (
            'true','" .
            $product->title . "','" .
            $product->description . "','" .
            $product->category . "','" .
            $product->productType . "','" .
            $product->brand . "','" .
            $product->sku . "','" .
            $product->groupingCode . "','" .
            $product->variantCode . "','" .
            $product->barcode . "','" .
            $product->weight . "','" .
            $product->costPrice . "','" .
            $product->sellingPrice . "','" .
            $product->quantity . "','" .
            $product->meta1 . "','" .
            $product->meta2 . "',"
            . "'" . $product->meta3 . "');"
        ;
        $output = $connection->converterObject($rawConnection, $query);
        $result = new \stdClass();
        $result->result = $output;
        $result->data = $product;
        return $result;

    }
}
?>

