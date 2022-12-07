<?php

namespace utils;

Class Utility
{
    function isNumeric($value, $field)
    {
        if(is_numeric($value))
        {
            $variable = new \stdClass();
            $variable->return = true;
            $variable->message = $field . ' Is Numeric';
            $variable->value = $value;
            return $variable;
        }
        else
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = $field . " is NOT numeric";
            $variable->value = $value;
            return $variable;
        }
    }
    function exist($variable)
    {
        if(isset($variable))
        {
            return $variable;
        }
        else
        {
            return false;
        }
    }

    function existID($customer, $rawConnection, $connect)
    {
        //checks ID
        $query = "SELECT COUNT(*) AS total FROM Client WHERE ID = '" . strtolower($customer['id']) . "'";
        $result = $connect->converterObject($rawConnection, $query);

        if($result->result[0]->total > 0)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = "ID already exists in Client Table";
            $variable->data = $result;
            return $variable;
        }
        else
        {
            return true;
        }
    }

    //variable product
    function existSKU($product, $rawConnection, $connect)
    {
        //checks SKU
        $query = "SELECT COUNT(*) AS total FROM Inventory WHERE SKU = '" . $product['sku'] . "'";
        $result = $connect->converterObject($rawConnection, $query);

        if($result->result[0]->total > 0)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = "SKU already exists in Inventory Table";
            $variable->data = $result;
            return $variable;
        }
        else
        {
            return true;
        }
    }

    function existVariantCode($product, $rawConnection, $connect)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        //checks variant code
        $rawConnection = $connect->createConnection($username, $password,"localhost", $dbName)->rawValue;
        
        $query = "SELECT COUNT(*) AS total FROM Inventory WHERE Variant_Code = '" . $product['variantCode'] . "'";
        $result = $connect->converterObject($rawConnection, $query);

        if($result->result[0]->total > 0)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = "Variant Code already exists in Inventory Table";
            $variable->data = $result;
            return $variable;
        }
        else
        {
            return true;
        }
    }

    //going to be cringe
    //variable products only
    function existOptions($product, $rawConnection, $connect)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        $rawConnection = $connect->createConnection($username, $password,"localhost", $dbName)->rawValue;

        //checks how many times it has been repeated in current group code
        $query = 'SELECT COUNT(*) AS total FROM Inventory WHERE Option_1_Value = "' . $product['optionValue'] . '" && Group_Code = "' . $product['groupingCode'] . '"';
        $result = $connect->converterObject($rawConnection, $query);
        if($result->result[0]->total == 1)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = "Option Value {{" . $product['optionValue'] . "}} already exists under {{" . $product['groupingCode'] . "}} with the value {{" . $product['optionValue'] . "}}";
            $variable->data = $result;
            return $variable;
        }
        else if(isset($product['option2Name']) && $product['option2Name'] != '' && isset($product['option2Value']) && $product['option2Value'] != '')
        {
            $query = 'SELECT Group_Code FROM Inventory WHERE Option_2_Name = "' . $product['option2Name'] . '"';
            $result = $connect->converterObject($rawConnection, $query);

            //checks how many times it has been repeated in current group code
            $query = 'SELECT COUNT(*) AS total FROM Inventory WHERE Option_2_Value = "' . $product['option2Value'] . '" && Group_Code = "' . $product['groupingCode'] . '"';
            $result = $connect->converterObject($rawConnection, $query);

            if($result->result[0]->total == 1)
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->message = "Option Value {{" . $product['option2Value'] . "}} already exists under {{" . $product['groupingCode'] . "}} with the value {{" . $product['option2Value'] . "}}";
                $variable->data = $result;
                return $variable;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }

    //variable product
    function existSKUe($product, $rawConnection, $connect)
    {

        //checks SKU
        $query = "SELECT COUNT(*) AS total FROM Inventory WHERE SKU = '" . $product->sku . "'";
        $result = $connect->converterObject($rawConnection, $query);
        if($result->result[0]->total > 1)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = "SKU {{" . $product['sku'] . "}} already exists in Inventory Table";
            $variable->data = $result;
            return $variable;
        }
        else
        {
            return true;
        }
    }
    function existIDe($customer, $rawConnection, $connect)
    {
        //checks ID
        $query = "SELECT COUNT(*) AS total FROM Client WHERE ID = '" . strtolower($customer->id) . "'";
        $result = $connect->converterObject($rawConnection, $query);
        if($result->result[0]->total > 1)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = "ID already exists in Client Table";
            $variable->data = $result;
            return $variable;
        }
        else
        {
            return true;
        }
    }
    function existVariantCodee($product, $rawConnection, $connect)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        //checks variant code
        $rawConnection = $connect->createConnection($username, $password,"localhost", $dbName)->rawValue;
        
        $query = "SELECT COUNT(*) AS total FROM Inventory WHERE Variant_Code = '" . $product->variantCode . "'";
        $result = $connect->converterObject($rawConnection, $query);

        if($result->result[0]->total > 1)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = "Variant Code {{" . $product['variantCode'] . "}} already exists in Inventory Table";
            $variable->data = $result;
            return $variable;
        }
        else
        {
            return true;
        }
    }

    //going to be cringe
    //variable products only
    function existOptionse($product, $rawConnection, $connect)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        $rawConnection = $connect->createConnection($username, $password,"localhost", $dbName)->rawValue;

        //checks how many times it has been repeated in current group code
        $query = "SELECT COUNT(*) AS total FROM Inventory WHERE Option_1_Value = '" . $product->optionValue . "' && Group_Code = '" . $product->groupingCode . "'";
        $result = $connect->converterObject($rawConnection, $query);

        if($result->result[0]->total > 1)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = "Option Value {{" . $product->optionValue . "}} already exists under {{" . $product->groupingCode . "}} with the value {{" . $product->optionValue . "}}";
            $variable->data = $result;
            return $variable;
        }
        else if(isset($product->option2Name) && isset($product->option2Value))
        {
            $query = "SELECT Group_Code FROM Inventory WHERE Option_2_Name = '" . $product->option2Name . "'";
            $result = $connect->converterObject($rawConnection, $query);

            //checks how many times it has been repeated in current group code
            $query = "SELECT COUNT(*) AS total FROM Inventory WHERE Option_2_Value = '" . $product->option2Value . "' && Group_Code = '" . $product->groupingCode . "'";
            $result = $connect->converterObject($rawConnection, $query);

            if($result->result[0]->total > 1)
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->message = "Option Value {{" . $product->option2Value . "}} already exists under {{" . $product->groupingCode . "}} with the value {{" . $product->option2Value . "}}";
                $variable->data = $result;
                return $variable;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }
    function optionCheck($product)
    {
        //$productTemplate = array('title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'comparePrice', 'sellingPrice',
        //'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3');
        if($product['groupingCode'] == null)
        {
            if($product['optionValue'] == null && $product['optionName'] != null)
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->message = 'Error: Variant option value is defined but no name has been set';
                return $variable;
            }
            else if($product['option2Value'] == null && $product['option2Name'] != null)
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->message = 'Error: Variant option value is defined but no name has been set';
                return $variable;

            }
            else if($product['optionValue'] != null && $product['optionName'] == null)
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->message = 'Error: Variant option name is defined but no value has been set';
                return $variable;
            }
            else if($product['option2Value'] != null && $product['option2Name'] == null)
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->message = 'Error: Variant option name is defined but no value has been set';
                return $variable;
            }
            else if($product['groupingCode'] == null)
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->message = 'Error: Group Code has not been defined or is empty';
                return $variable;
            }
            else
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->message = 'Unknown condition encountered';
                return $variable;
            }
        }
        else if($product['groupingCode'] != null)
        {
            if($product['optionName'] == null || $product['optionValue'] == null)
            {
                $variable = new \stdClass();
                $variable->return = false;
                $variable->message = 'Attempting to create variable product without Options';
                return $variable;
            }
            else if($product['option2Name'] == null || $product['option2Value'] == null)
            {
                if($product['optionName'] == null || $product['optionValue'] == null)
                {
                    $variable = new \stdClass();
                    $variable->return = false;
                    $variable->message = 'Attempting to create variable product without Options';
                    return $variable;
                }
                else if($product['option2Name'] == null && $product['option2Value'] != null)
                {
                    $variable = new \stdClass();
                    $variable->return = false;
                    $variable->message = 'Attempting to create variable product without Option Name';
                    return $variable;
                }
                else if($product['option2Name'] != null && $product['option2Value'] == null)
                {
                    $variable = new \stdClass();
                    $variable->return = false;
                    $variable->message = 'Attempting to create variable product without Option Value';
                    return $variable;
                }
            }
        }
    }
    //stdClass
    function checkRequired($product)
    {
        $required = array('active', 'sku', 'groupingCode', 'variantCode');
        for($i = 0; $i < sizeof($required); ++$i)
        {
            $index = $required[$i];
            if(!isset($product->$index))
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->header = $required[$i];
                return $variable;
            }
        }
        $variable = new \stdClass();
        $variable->result = true;
        return $variable;
    }
    
    //array
    function checkRequiredH($product)
    {
        $required = array('active', 'sku', 'groupingCode', 'variantCode');
        for($i = 0; $i < sizeof($required); ++$i)
        {
            $index = $required[$i];
            if(!isset($product[$index]))
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->header = $index;
                return $variable;
            }
        }
        $variable = new \stdClass();
        $variable->result = true;
        return $variable;
    }

    //writes data to a file
    //parameters are:
    //$filename - name of the file to write to
    //$ $writeMethod 
    function writeToFile($filename, $writeMethod, $data)
    {
        $myfile = fopen("../bin/output/" . $filename, $writeMethod) or die("Unable to open file!");
        fwrite($myfile, $data);
        fclose($myfile);
    }

    //function to unserialize order object
    //parameter is a countable array
    function unserializeOrder($orderArray)
    {
        $serialValues = ['billingAddress', 'customer', 'lineItems', 'paymentDetails', 
        'shippingAddress', 'shippingLines', 'taxLines', 'wooOrder'];

        if($orderArray == null || sizeof($orderArray) < 0)
        {
            return $orderArray;
        }
        else
        {
            //for each order in the list of orders
            for($i = 0; $i < sizeof($orderArray); ++$i)
            {
                //for each serialValues in the array
                for($j = 0; $j < sizeof($serialValues); ++$j)
                {
                    if(isset($orderArray[$i]->{"$serialValues[$j]"}))
                    {
                        $orderArray[$i]->{"$serialValues[$j]"} = unserialize($orderArray[$i]->{"$serialValues[$j]"});
                    }
                }
            }
        }
        return $orderArray;
    }
}

?>