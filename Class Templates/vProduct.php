<?php

namespace vProducts;

Class vProducts
{
    private $product;

    function createProduct($product, $util, $connection, $update = '')
    {
        //checks if all the numeric values entered are numeric...
        $numeric = array("barcode", "weight", "comparePrice", "sellingPrice", "quantity"); //array of numeric values
        for($j = 0; $j < sizeof($numeric); ++$j)
        {
            if(isset($product[$numeric[$j]]))
            {
                if($product[$numeric[$j]] != null)
                {
                    //check if they are numeric using the util class -- its a parameter
                    $variable = $util->isNumeric($product[$numeric[$j]], $numeric[$j]);
                    if($variable->return == false)
                    {
                        // returns the values that are not numeric...
                        return $variable;
                    }
                }
            }
        }

        //query against Database to check if the options, SKU, source variant codes are repeated?_?

        //create connection first
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;
        if($update == 'edit')
        {           
            //creates the product
            $productTemplate = array('active', 'title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'comparePrice', 'sellingPrice',
            'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3');

            
            if($util->optionCheck($product))
            {
                return $util->optionCheck($product);
            }
            //creates as a standard class
            $this->product = new \stdClass();
            for($i = 0; $i < sizeof($productTemplate); ++$i)
            {
                //for debugging only 
                //print_r($product[$productTemplate[$i]]);
                //echo("<br>");
                
                //check if the productOption has been created without a value
                
                if(isset($product[$productTemplate[$i]]) && $product[$productTemplate[$i]] != 'null')
                {
                    //converts to a string
                    $variable = $productTemplate[$i];
                    $this->product->$variable = addslashes($product[$productTemplate[$i]]);
                }
                else
                {
                    $variable = $productTemplate[$i];
                    $this->product->$variable = null;
                }
            }
            return $this->product;
        }
        else
        {
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

            //checks for duplicate options
            if($util->existOptions($product, $rawConnection, $connection) !== true)
            {
                return $util->existOptions($product, $rawConnection, $connection);
            }
            //creates the product
            $productTemplate = array('title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'comparePrice', 'sellingPrice',
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
                    $this->product->$variable = addslashes($product[$productTemplate[$i]]);
                }
                else
                {
                    $variable = $productTemplate[$i];
                    $this->product->$variable = null;
                }
            }
            return $this->product;
        }   
    }
    function addProduct($product, $connection)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;
        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;

        $query = "INSERT INTO Inventory 
        (
            Type,
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
            ComparePrice,
            SellingPrice,
            CapeTown_Warehouse,
            Option_1_Name,
            Option_1_Value,
            Option_2_Name,
            Option_2_Value,
            Meta_1,
            Meta_2,
            Meta_3
        )

        VALUES 
        (
            'Variant',
            'true','" .
            $product->title . "','" .
            addslashes(str_replace('"', "", $product->description)) . "','" .
            $product->category . "','" .
            $product->productType . "','" .
            $product->brand . "','" .
            $product->sku . "','" .
            $product->groupingCode . "','" .
            $product->variantCode . "','" .
            $product->barcode . "','" .
            $product->weight . "','" .
            $product->comparePrice . "','" .
            $product->sellingPrice . "','" .
            round($product->quantity, 0) . "','" .
            $product->optionName . "','" .
            $product->optionValue . "','" .
            $product->option2Name . "','" .
            $product->option2Value . "','" .
            $product->meta1 . "','" .
            $product->meta2 . "',"
            . "'" . $product->meta3 . "');"
        ;
        $output = $connection->converterObject($rawConnection, $query);
        $result = new \stdClass();
        $result->data = $product;
        return $result;

    }
    function updateProduct($product, $util, $connection)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;
        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;

        if($product->sku == null || $product->variantCode == null || $product->groupingCode == null)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = 'Undefined property';
            return $variable;
        }
        //must check if the respective data already exists in the database
        if($util->existSKUe($product, $rawConnection, $connection) !== true)
        {
            return $util->existSKUe($product, $rawConnection, $connection);
        }
        
        //checks variantCode
        if($util->existVariantCodee($product, $rawConnection, $connection) !== true)
        {
            return $util->existVariantCodee($product, $rawConnection, $connection);
        }

        //checks for duplicate options
        if($util->existOptionse($product, $rawConnection, $connection) !== true)
        {
            return $util->existOptionse($product, $rawConnection, $connection);
        }
        //checks if the product has a valid active field
        if($product->active != 'true' && $product->active != 'false')
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->message = 'Unsupported value';
            $variable->supportedValues = array(true, false);
            return $variable;
        }

        if(isset($_SESSION['edit_prod']))
        {
            if($_SESSION['edit_prod'] == $product)
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->message = "No changes have been detected";
                unset($_SESSION['edit_prod']);
                return $variable;
            }
            unset($_SESSION['edit_prod']);
        }

        $query = "UPDATE Inventory 

        SET 
            Type = 'Variant',
            Active = '$product->active',
            Title = '$product->title',
            Description = '" . addslashes(str_replace('"', "", $product->description)) . "',
            Category = '$product->category',
            Product_Type = '$product->productType',
            Brand = '$product->brand',
            SKU = '$product->sku',
            Group_Code = '$product->groupingCode',
            Variant_Code = '$product->variantCode',
            Barcode = '$product->barcode',
            Weight = '$product->weight',
            ComparePrice = '$product->comparePrice',
            SellingPrice = '$product->sellingPrice',
            CapeTown_Warehouse = '$product->quantity',
            Option_1_Name = '$product->optionName',
            Option_1_Value = '$product->optionValue',
            Option_2_Name = '$product->option2Name',
            Option_2_Value = '$product->option2Value',
            Meta_1 = '$product->meta1',
            Meta_2 = '$product->meta2',
            Meta_3 = '$product->meta1'

        WHERE SKU = '$product->sku'"
        ;

        $output = $connection->converterObject($rawConnection, $query);
        $result = new \stdClass();
        $result->data = $product;
        return $result;
    }
}
?>

