<?php

namespace utils;

Class Utility
{
    /**
     * Checks if `value` is numeric
     */
    function isNumeric(string $value, string $field)
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

    /**
     * Checks if the current `customer` ID exists in the database already
     * @return bool
     */
    function existID(array $customer, \mysqli $rawConnection, \Connection\Connection $connect)
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

    /**
     * Checks if the current `product` SKU exists in the database already
     * @return bool
     */
    function existSKU(array $product, \mysqli $rawConnection, \Connection\Connection $connect)
    {
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

    /**
     * Checks if the variant code of the current product already exists in the database
     * @return bool
     */
    function existVariantCode(array $product, \mysqli $rawConnection, \Connection\Connection $connect)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

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

    //variable products only
    /**
     * Checks if there are any repeated option values in the current `product` group_code
     * @return bool
     */
    function existOptions(array $product, \mysqli $rawConnection, \Connection\Connection $connect)
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

    /**
     * Checks if the current `product` SKU already exists in the database (edit)
     *  @return bool
     */
    function existSKUe(\stdClass $product, \mysqli $rawConnection, \Connection\Connection $connect)
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

    /**
     * Checks if the current `customer` ID already exists in the database (edit)
     *  @return bool
     */
    function existIDe(\stdClass $customer, \mysqli $rawConnection, \Connection\Connection $connect)
    {
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

    /**
     * Checks if the current `products` variant_code already exists in the database (edit)
     *  @return bool
     */
    function existVariantCodee(\stdClass $product, \mysqli $rawConnection, \Connection\Connection $connect)
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

    //variable products only
    /**
     * Checks if there are any repeated option values in the current `product` group_code
     * @return bool
     */
    function existOptionse(\stdClass $product, \mysqli $rawConnection, \Connection\Connection $connect)
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

    /**
     * Checks the option values/names of the current `product`
     * @return \stdClass
     */
    function optionCheck($product)
    {
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
    
    /**
     * Checks if the required fields are defined as headers on the import file
     * @return \stdClass
     */
    function checkRequired(\stdClass $product)
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
    
    /**
     * Checks if the required fields are defined as headers on the template
     * @return \stdClass
     */
    function checkRequiredH(\stdClass $product)
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

    /**
     * Writes data to a file
     * @return void
     */
    function writeToFile(string $filename, string $writeMethod, string $data)
    {
        $myfile = fopen("../bin/output/" . $filename, $writeMethod) or die("Unable to open file!");
        fwrite($myfile, $data);
        fclose($myfile);
    }

    /**
     * Unserialize order object
     * @return array
     */
    function unserializeOrder(array $orderArray, bool $wooOrder = false)
    {
        if($wooOrder == true)
        {
            $serialValues = ['billing_address', 'customer', 'line_items', 'payment_details', 
            'shipping_address', 'shipping_lines', 'tax_lines'];
        }
        else
        {
            $serialValues = ['billingAddress', 'customer', 'lineItems', 'paymentDetails', 
            'shippingAddress', 'shippingLines', 'taxLines', 'wooOrder'];
        }

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
    /**
     * Removes duplicates from search results
     * @return \stdClass
     */
    function removeDuplicates(\stdClass $variable, string $type)
    {
        $result = [];
        $array_values = [];
        if($type == 'prod')
        {
            for($i = 0; $i < sizeof($variable->body); ++$i)
            {
                if(!in_array($variable->body[$i]->SKU, $array_values))
                {
                    array_push($result, $variable->body[$i]);
                    array_push($array_values, $variable->body_1[$i]->SKU);
                }
                else
                {
                    array_push($array_values, $variable->body[$i]->SKU);
                }
            }

            //
            for($i = 0; $i < sizeof($variable->body_1); ++$i)
            {
                if(!in_array($variable->body_1[$i]->SKU, $array_values))
                {
                    array_push($result, $variable->body_1[$i]);
                    array_push($array_values, $variable->body_1[$i]->SKU);
                }
                else
                {
                    array_push($array_values, $variable->body_1[$i]->SKU);
                }
            }
            //

            for($i = 0; $i < sizeof($variable->body_2); ++$i)
            {
                if(!in_array($variable->body_2[$i]->SKU, $array_values))
                {
                    array_push($result, $variable->body_2[$i]);
                    array_push($array_values, $variable->body_1[$i]->SKU);
                }
                else
                {
                    array_push($array_values, $variable->body_2[$i]->SKU);
                }
            }
        }
        else if($type == 'cust')
        {
            for($i = 0; $i < sizeof($variable->body); ++$i)
            {
                if(!in_array($variable->body[$i]->ID, $array_values))
                {
                    array_push($result, $variable->body[$i]);
                    array_push($array_values, $variable->body[$i]->ID);
                }
                else
                {
                    array_push($array_values, $variable->body[$i]->ID);
                }
            }

            //
            for($i = 0; $i < sizeof($variable->body_1); ++$i)
            {
                if(!in_array($variable->body_1[$i]->ID, $array_values))
                {
                    array_push($result, $variable->body_1[$i]);
                    array_push($array_values, $variable->body_1[$i]->ID);
                }
                else
                {
                    array_push($array_values, $variable->body_1[$i]->ID);
                }
            }
            //

            for($i = 0; $i < sizeof($variable->body_2); ++$i)
            {
                if(!in_array($variable->body_2[$i]->ID, $array_values))
                {
                    array_push($result, $variable->body_2[$i]);
                    array_push($array_values, $variable->body_1[$i]->ID);
                }
                else
                {
                    array_push($array_values, $variable->body_2[$i]->ID);
                }
            }
        }
        else if($type == 'order')
        {
            for($i = 0; $i < sizeof($variable->body); ++$i)
            {
                if(!in_array($variable->body[$i]->ID, $array_values))
                {
                    array_push($result, $variable->body[$i]);
                    array_push($array_values, $variable->body[$i]->ID);
                }
                else
                {
                    array_push($array_values, $variable->body[$i]->ID);
                }
            }

            //
            for($i = 0; $i < sizeof($variable->body_1); ++$i)
            {
                if(!in_array($variable->body_1[$i]->ID, $array_values))
                {
                    array_push($result, $variable->body_1[$i]);
                    array_push($array_values, $variable->body_1[$i]->ID);
                }
                else
                {
                    array_push($array_values, $variable->body_1[$i]->ID);
                }
            }
            //

            for($i = 0; $i < sizeof($variable->body_2); ++$i)
            {
                if(!in_array($variable->body_2[$i]->ID, $array_values))
                {
                    array_push($result, $variable->body_2[$i]);
                    array_push($array_values, $variable->body[$i]->ID);
                }
                else
                {
                    array_push($array_values, $variable->body_2[$i]->ID);
                }
            }
        }
        $result_object = new \stdClass();
        $result_object->result = $result;
        return $result_object;
    }
    
    /**
     * Compares two conditions
     * @return bool
     */
    function compareCondition(\stdClass $condition1, \stdClass $condition2)
    {
        if($condition1->dataValue == $condition2->DataValue)
        {
            if($condition1->statement == $condition2->Statement)
            {
                if($condition1->value == $condition2->Value)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Converts the query output for js functions to use
     * @return \stdClass
     */
    function convert_query_output($output, $message)
    {
        if($output->result == true)
        {
            $variable = new \stdClass();
            $variable->return = $output->result;
            $variable->body = $message;
        }
        else
        {
            $variable = new \stdClass();
            $variable->return = $output->result;
            $variable->body = $output->message;
        }
        return $variable;
    }
}

?>