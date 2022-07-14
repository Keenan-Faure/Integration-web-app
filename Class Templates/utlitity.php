<?php

namespace utils;

Class Utility
{
    function isNumeric($value)
    {
        if(is_numeric($value))
        {
            $variable = new \stdClass();
            $variable->result = true;
            $variable->message = 'Is Numeric';
            $variable->value = $value;
            return $variable;
        }
        else
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->message = $value . " is NOT numeric";
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
}

?>