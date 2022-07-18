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
    function existSKU($product, $rawConnection, $connect)
    {

        //checks SKU
        $query = "select count(*) as total from Inventory where SKU = '" . $product['sku'] . "'";
        $result = $connect->converterObject($rawConnection, $query);

        if($result->result[0]->total > 0)
        {
            $variable = new \stdClass();
            $variable->data = $result;
            $variable->message = "SKU {{" . $product['sku'] . "}} already exists in Inventory Table";
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
        
        $query = "select count(*) as total from Inventory where Variant_Code = '" . $product['variantCode'] . "'";
        $result = $connect->converterObject($rawConnection, $query);

        if($result->result[0]->total > 0)
        {
            $variable = new \stdClass();
            $variable->data = $result;
            $variable->message = "Variant Code {{" . $product['variantCode'] . "}} already exists in Inventory Table";
            return $variable;
        }
        else
        {
            return true;
        }
    }

    //going to be cringe
    function existOptions($product, $rawConnection, $connect)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        //checks variant code
        $rawConnection = $connect->createConnection($username, $password,"localhost", $dbName)->rawValue;
        
        $query = "select Group_Code from Inventory where Option_1_Name = '" . $product['optionName'] . "'";
        $result = $connect->converterObject($rawConnection, $query);
        return $result;

        
    }
}

?>