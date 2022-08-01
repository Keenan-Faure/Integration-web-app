<?php

namespace utils;

Class Utility
{
    function isNumeric($value, $field)
    {
        if(is_numeric($value))
        {
            $variable = new \stdClass();
            $variable->result = true;
            $variable->message = $field . ' Is Numeric';
            $variable->value = $value;
            return $variable;
        }
        else
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->message = $field . " {{" . $value . "}} is NOT numeric";
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
        //checks SKU
        $query = "SELECT COUNT(*) AS total FROM Client WHERE ID = '" . strtolower($customer['id']) . "'";
        $result = $connect->converterObject($rawConnection, $query);

        if($result->result[0]->total > 0)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->message = "ID {{" . $customer['id'] . "}} already exists in Client Table";
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
            $variable->message = "SKU {{" . $product['sku'] . "}} already exists in Inventory Table";
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
    function existOptions($product, $rawConnection, $connect)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        $rawConnection = $connect->createConnection($username, $password,"localhost", $dbName)->rawValue;

        //checks how many times it has been repeated in current group code
        $query = "SELECT COUNT(*) AS total FROM Inventory WHERE Option_1_Value = '" . $product['optionValue'] . "' && Group_Code = '" . $product['groupingCode'] . "'";
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
            $query = "SELECT Group_Code FROM Inventory WHERE Option_2_Name = '" . $product['option2Name'] . "'";
            $result = $connect->converterObject($rawConnection, $query);

            //checks how many times it has been repeated in current group code
            $query = "SELECT COUNT(*) AS total FROM Inventory WHERE Option_2_Value = '" . $product['option2Value'] . "' && Group_Code = '" . $product['groupingCode'] . "'";
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
            $variable->message = "Option Value {{" . $product['optionValue'] . "}} already exists under {{" . $product['groupingCode'] . "}} with the value {{" . $product['optionValue'] . "}}";
            $variable->data = $result;
            return $variable;
        }
        else if(isset($product->option2Name) && isset($product->option2Value))
        {
            $query = "SELECT Group_Code FROM Inventory WHERE Option_2_Name = '" . $product['option2Name'] . "'";
            $result = $connect->converterObject($rawConnection, $query);

            //checks how many times it has been repeated in current group code
            $query = "SELECT COUNT(*) AS total FROM Inventory WHERE Option_2_Value = '" . $product->option2Value . "' && Group_Code = '" . $product->groupingCode . "'";
            $result = $connect->converterObject($rawConnection, $query);

            if($result->result[0]->total > 1)
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



}

?>