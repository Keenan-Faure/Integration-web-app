<?php

namespace customer;

use utils\Utility;

Class Customers
{
    private \stdClass $customer;

    /**
     * Creates/updates a customer dependent on the value of `update`
     * @return \stdClass
     */
    function createCustomer(array $customer, \utils\Utility $util, \Connection\Connection $connection, string $update = '')
    {
        if(!filter_var($customer['email'], FILTER_VALIDATE_EMAIL))
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->error = "Invalid Email: " . $customer['email'];
            return $variable;
        }

        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;

        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;

        if($update == 'edit')
        {
            $customerTemplate = array('active', 'id','name', 'surname', 'email', 'address1', 'address2', 'address3', 'address4');

            $customer['id'] = strtolower($customer['name']) . '-' . strtolower($customer['surname']);
            $this->customer = new \stdClass();
            for($i = 0; $i < sizeof($customerTemplate); ++$i)
            {
                if(isset($customer[$customerTemplate[$i]]) && $customer[$customerTemplate[$i]] != 'null')
                {
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
            if($util->existID($customer, $rawConnection, $connection) !== true)
            {
                return $util->existID($customer, $rawConnection, $connection);
            }

            $customerTemplate = array('id','name', 'surname', 'email', 'address1', 'address2', 'address3', 'address4');
            $this->customer = new \stdClass();
            for($i = 0; $i < sizeof($customerTemplate); ++$i)
            {
                if(isset($customer[$customerTemplate[$i]]))
                {
                    $variable = $customerTemplate[$i];
                    $this->customer->$variable = $customer[$customerTemplate[$i]];
                }
            }
            return $this->customer;
        }
    }
    /**
     * Adds a customer into the database
     * @return \stdClass
     */
    function addCustomer(\stdClass $customer, \Connection\Connection $connection)
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
            Address_4,
            Audit_Date,
            Users
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
            $customer->address3 . "','" . 
            $customer->address4 . "','" .
            date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']) . "','"
            . $_SESSION['clientConn']->token . "');"
        ;
        $connection->converterObject($rawConnection, $query);
        $result = new \stdClass();
        $result->data = $customer;
        return $result;
    }

    /**
     * Updates an existing customer in the database
     * @return \stdClass
     */
    function updateCustomer(\stdClass $customer, \utils\Utility $util, \Connection\Connection $connection)
    {
        $date = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        $user = $_SESSION['clientConn']->token;
        
        $username = $_SESSION['connection']->credentials->username;
        $password = $_SESSION['connection']->credentials->password;
        $dbName = $_SESSION['connection']->credentials->dbname;
        $rawConnection = $connection->createConnection($username, $password,"localhost", $dbName)->rawValue;

        if($util->existIDe($customer, $rawConnection, $connection) !== true)
        {
            return $util->existIDe($customer, $rawConnection, $connection);
        }
        
        if($customer->active != 'true' && $customer->active != 'false')
        {
            $variable = new \stdClass();
            $variable->result = false;
            $variable->message = 'Unsupported value: ' . $customer->active;
            $variable->supportedValues = array(true, false);
            return $variable;
        }

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
            Address_4 = '$customer->address4',
            Audit_Date = '$date',
            Users = '$user'
            
        WHERE ID = '$customer->id'"
        ;

        $connection->converterObject($rawConnection, $query);
        $result = new \stdClass();
        $result->data = $customer;
        return $result;
    }
}
?>