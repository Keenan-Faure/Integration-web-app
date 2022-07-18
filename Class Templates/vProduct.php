<?php

namespace vProducts;

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

        //creates the product
        $productTemplate = array('title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'costPrice', 'sellingPrice',
        'whseName', 'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3');

        $this->product = new \stdClass();
        for($i = 0; $i < sizeof($productTemplate); ++$i)
        {
            print_r($product[$productTemplate[$i]]);
            echo("<br>");
            if(isset($product[$productTemplate[$i]]))
            {
                $variable = json_encode($productTemplate);
                $this->product->$variable[$i] = $product[$productTemplate[$i]];
                
            }
        }
        print_r($this->product);
    }
}
?>

