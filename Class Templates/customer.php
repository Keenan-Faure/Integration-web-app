<?php

namespace customer;

Class Customers
{
    private $customer;

    function createCustomer($customer, $util, $connection, $update = '')
    {
        if(!filter_var($customer['email'], FILTER_VALIDATE_EMAIL))
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->error = "Invalid Email: " . $customer['email'];
            return $variable;
        }

        //create connection first
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        //checks SKU
        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;

        if($update == 'edit')
        {
            //creates the customer
            $customerTemplate = array('active', 'id','name', 'surname', 'email', 'address1', 'address2', 'address3', 'address4');

            $customer['id'] = strtolower($customer['name']) . '-' . strtolower($customer['surname']);
            //creates as a standard class
            $this->customer = new \stdClass();
            for($i = 0; $i < sizeof($customerTemplate); ++$i)
            {
                //for debugging only 

                //print_r($customer[$customerTemplate[$i]]);
                //echo("<br>");
                if(isset($customer[$customerTemplate[$i]]) && $customer[$customerTemplate[$i]] != 'null')
                {
                    //converts to a string
                    $variable = $customerTemplate[$i];
                    $this->customer->$variable = $customer[$customerTemplate[$i]];
                }
                else
                {
                    $variable = $customerTemplate[$i];
                    $this->customer->$variable = null;
                }
            }
            return $this->customer;
        }
        else
        {

            $customer['id'] = strtolower($customer['name']) . '-' . strtolower($customer['surname']);

            //checks ID
            if($util->existID($customer, $rawConnection, $connection) !== true)
            {
                return $util->existID($customer, $rawConnection, $connection);
            }

            //creates the customer
            $customerTemplate = array('id','name', 'surname', 'email', 'address1', 'address2', 'address3', 'address4');

            //creates as a standard class
            $this->customer = new \stdClass();
            for($i = 0; $i < sizeof($customerTemplate); ++$i)
            {
                //for debugging only 

                //print_r($customer[$customerTemplate[$i]]);
                //echo("<br>");
                if(isset($customer[$customerTemplate[$i]]))
                {
                    //converts to a string
                    $variable = $customerTemplate[$i];
                    $this->customer->$variable = $customer[$customerTemplate[$i]];
                }
            }
            return $this->customer;
        }
    }
    function addCustomer($customer, $connection)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;
        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;
        $query = "INSERT INTO Client 
        (
            Active,
            ID,
            Name,
            Surname,
            Email,
            Address_1,
            Address_2,
            Address_3,
            Address_4
        )
        VALUES 
        (
            'true','" .
            strtolower($customer->id) . "','" .
            $customer->name . "','" .
            $customer->surname . "','" .
            $customer->email . "','" .
            $customer->address1 . "','" .
            $customer->address2 . "','" .
            $customer->address3 . "','"
            . "" . $customer->address4 . "');"
        ;
        $output = $connection->converterObject($rawConnection, $query);
        $result = new \stdClass();
        $result->result = $output;
        $result->data = $customer;
        return $result;

    }
    function updateCustomer($customer, $util, $connection)
    {
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;
        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;

        //checks SKU

        if($util->existIDe($customer, $rawConnection, $connection) !== true)
        {
            return $util->existIDe($customer, $rawConnection, $connection);
        }
        
        if(isset($_SESSION['edit_cust']))
        {
            if($_SESSION['edit_cust'] == $customer)
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->message = "No changes have been detected";
                unset($_SESSION['edit_cust']);
                return $variable;
            }
        }
        if($customer->active != 'true' && $customer->active != 'false')
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->message = 'Unsupported value: ' . $customer->active;
            $variable->supportedValues = array(true, false);
            return $variable;
        }
        unset($_SESSION['edit_cust']);

        $query = "UPDATE Client 

        SET 
            Active = '$customer->active',
            ID = '$customer->id',
            Name = '$customer->name',
            Surname = '$customer->surname',
            Email = '$customer->email',
            Address_1 = '$customer->address1',
            Address_2 = '$customer->address2',
            Address_3 = '$customer->address3',
            Address_4 = '$customer->address4'

        WHERE ID = '$customer->id'"
        ;

        $output = $connection->converterObject($rawConnection, $query);
        $result = new \stdClass();
        $result->data = $customer;
        return $result;
    }
}
?>