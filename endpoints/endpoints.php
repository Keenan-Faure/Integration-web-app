<?php

session_start();

include("../Class Templates/createConnection.php");
include("../Class Templates/utility.php");

use Connection\Connection as connect;
use utils\Utility as util;

$connection = new connect();
$util = new util();

//queries the params
$host = "http://" . $_SERVER['HTTP_HOST'];
$fullUrl = $_SERVER["REQUEST_URI"];
$fullUrl = $host . $fullUrl;

$params = ($connection->queryParams($fullUrl));
$function = $params['func'];
$function($connection, $util, $params);

/**
 * Fetches IDs from Database. Uses inner join on Woocommerce & Inventory tables 
 * @return \stdClass
 */
function get_ids(connect $connection, util $util, array $params)
{
    if(!isset($_SESSION['connection']))
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found";
        echo(json_encode($variable));
        exit();
    }
    $sku = $params['sku'];

    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $query2 = 'SELECT Pushed FROM Stock2Shop WHERE SKU = "' . $sku . '"';
    $query3 = 'SELECT woo.P_ID, woo.ID, woo.SKU, inv.Audit_Date, inv.Users FROM Woocommerce woo INNER JOIN Inventory inv ON inv.SKU = woo.SKU WHERE woo.SKU = "' . $sku . '"';
    $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
    $output3 = $connection->converterObject($rawConnection, $query3, $_SESSION['connection']->credentials->dbname);

    if($output2 == null)
    {
        $output2 = 'null';
    }
    if($output3 == null)
    {
        $output3 = 'null';
    }
    $variable = new \stdClass();
    $variable->return = true;
    $variable->body = $output2;
    $variable->body_1 = $output3;
    echo(json_encode($variable));
}

/**
 * Search endpoint for products/orders/customers. Searches through the respective tables in the database
 * @return void
 */
function get_search(connect $connection, util $util, array $params)
{
    if(!isset($_SESSION['connection']))
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found";
        echo(json_encode($variable));
        exit();
    }
    $type = $params['type'];
    $q = $params['q'];
    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;

    if($type == 'cust')
    {
        /**
         * search based on:
         * Name
         * Surname
         * Email
        */
        $query = 'SELECT DISTINCT ID, Name, Surname, Email FROM Client WHERE Name LIKE "%' . $q. '%" LIMIT 5';
        $output = $connection->converterObject($rawConnection, $query, $_SESSION['connection']->credentials->dbname);
        $result = $output->result;

        $query1 = 'SELECT DISTINCT ID, Name, Surname, Email FROM Client WHERE Surname LIKE "%' . $q. '%" LIMIT 5';
        $output1 = $connection->converterObject($rawConnection, $query1, $_SESSION['connection']->credentials->dbname);
        $result1 = $output1->result;

        $query2 = 'SELECT DISTINCT ID, Name, Surname, Email FROM Client WHERE Email LIKE "%' . $q. '%" LIMIT 5';
        $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $result2 = $output2->result;

        $variable = new \stdClass();
        $variable->return = true;
        $variable->body = $result;
        $variable->body_1 = $result1;
        $variable->body_2 = $result2;

        //removed duplicates from results
        echo(json_encode($util->removeDuplicates($variable, 'cust')));
    }
    else if($type == 'prod')
    {
        /**
         * search based on:
         * collection
         * title
         * SKU
        */
        $query = 'SELECT DISTINCT Title, SKU, Group_Code, Brand FROM Inventory WHERE Category LIKE "%' . $q. '%" LIMIT 5';
        $output = $connection->converterObject($rawConnection, $query, $_SESSION['connection']->credentials->dbname);
        $result = $output->result;

        $query1 = 'SELECT DISTINCT Title, SKU, Group_Code, Brand FROM Inventory WHERE Title LIKE "%' . $q. '%" LIMIT 5';
        $output1 = $connection->converterObject($rawConnection, $query1, $_SESSION['connection']->credentials->dbname);
        $result1 = $output1->result;

        $query2 = 'SELECT DISTINCT Title, SKU, Group_Code, Brand FROM Inventory WHERE SKU LIKE "%' . $q. '%" LIMIT 5';
        $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $result2 = $output2->result;

        $variable = new \stdClass();
        $variable->return = true;
        $variable->body = $result;
        $variable->body_1 = $result1;
        $variable->body_2 = $result2;

        //removed duplicates from results
        echo(json_encode($util->removeDuplicates($variable, 'prod')));
    }
    else if($type == 'order')
    {
        /**
         * search based on:
         * ID
         * orderStatus
         * note
        */
        $query = 'SELECT DISTINCT ID, orderStatus, note, createdDate FROM Orders WHERE ID LIKE "%' . $q. '%" LIMIT 5';
        $output = $connection->converterObject($rawConnection, $query, $_SESSION['connection']->credentials->dbname);
        $result = $output->result;

        $query1 = 'SELECT DISTINCT ID, orderStatus, note, createdDate FROM Orders WHERE orderStatus LIKE "%' . $q. '%" LIMIT 5';
        $output1 = $connection->converterObject($rawConnection, $query1, $_SESSION['connection']->credentials->dbname);
        $result1 = $output1->result;

        $query2 = 'SELECT DISTINCT ID, orderStatus, note, createdDate FROM Orders WHERE note LIKE "%' . $q. '%" LIMIT 5';
        $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $result2 = $output2->result;

        $variable = new \stdClass();
        $variable->return = true;
        $variable->body = $result;
        $variable->body_1 = $result1;
        $variable->body_2 = $result2;

        //removed duplicates from results
        echo(json_encode($util->removeDuplicates($variable, 'order')));
    }
    else
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "Invalid API call";
        echo(json_encode($variable));
    }
}

/**
 * Gets the session, as a json object, and returns it
 * @return void
 */
function get_ses(connect $connection, util $util, array $params)
{
    if(isset($_SESSION['connection']))
    {
        echo(json_encode($_SESSION['clientConn']));
    }
    else
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found";
        echo(json_encode($variable));
    }
}

/**
 * Gets all products in the Inventory table that:
 *      - That has a recent audit date
 *      - Is active to sync
 * @return void
 */
function get_sku(connect $connection, util $util, array $params)
{
    if(!isset($_SESSION['connection']))
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found";
        echo(json_encode($variable));
        exit();
    }
    $connector = $params['conn'];
    if($connector == 'woo')
    {
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $query2 = 'SELECT inv.SKU FROM Inventory inv INNER JOIN Woocommerce woo ON inv.SKU = woo.SKU WHERE inv.Audit_Date > woo.pushDate AND Active = "true"';
        $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $result = $output2->result;
        $variable = new \stdClass();
        $variable->return = true;
        $variable->body = $result;
        echo(json_encode($variable));
    }
    else if($connector == 's2s')
    {
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $conditions = $connection->converterObject($rawConnection, "SELECT * FROM Conditions", $_SESSION['connection']->credentials->dbname);
        $query2 = 'SELECT inv.SKU FROM Inventory inv INNER JOIN Stock2Shop s2s ON inv.SKU = s2s.SKU WHERE inv.Audit_Date > s2s.pushDate AND Active = "true"';
        $query2 = $util->createQuery($conditions, $query2);
        $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $result = $output2->result;
        $variable = new \stdClass();
        $variable->return = true;
        $variable->body = $result;
        echo(json_encode($variable));
    }
    else
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No connector param found";
        echo(json_encode($variable));
    }
}

/**
 * Gets all users in the Client table
 * @return void
 */
function get_usz(connect $connection, util $util, array $params)
{
    if(!isset($_SESSION['connection']))
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found";
        echo(json_encode($variable));
        exit();
    }
    //check if token is valid
    $token = $params['token'];

    $query2 = 'SELECT * FROM Userz WHERE Token = "' . $token . '"';
    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
    if($output2->result == null)
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found or invalid Token";
        echo(json_encode($variable));
        exit();
    }
    else
    {
        $query2 = 'SELECT * FROM Userz';
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $result = json_encode($output2->result);
        echo($result);
        exit();
    }
}

/**
 * Updates the `Logs` table in the database
 * @return void
 */
function put_logs(connect $connection, util $util, array $params)
{
    if(!isset($_SESSION['connection']))
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found";
        echo(json_encode($variable));
        exit();
    }
    $token = $params['token'];
    $id = $params['id'];

    //check if token is valid
    $query2 = 'SELECT * FROM Userz WHERE Token = "' . $token . '"';
    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
    if($output2->result == null)
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found or invalid Token";
        echo(json_encode($variable));
        exit();
    }
    else
    {
        //$query2 = 'DELETE FROM Logs WHERE ID = "' . $id . '"';
        //'Update Userz set active = "true" where UserID = "1"'
        $query2 = 'DELETE FROM Logs WHERE ID = "' . $id . '"';
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $output2 = $util->convert_query_output($output2, "Success");
        echo(json_encode($output2));
        exit();
    }
}

/**
 * Updates the `Userz` table in the database
 * @return void
 */
function put_usz(connect $connection, util $util, array $params)
{
    if(!isset($_SESSION['connection']))
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found";
        echo(json_encode($variable));
        exit();
    }
    $token = $params['token'];
    $active = $params['active'];
    $id = $params['id'];

    //check if token is valid
    $query2 = 'SELECT * FROM Userz WHERE Token = "' . $token . '"';
    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
    if($output2->result == null)
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->body = "No session found or invalid Token";
        echo(json_encode($variable));
        exit();
    }
    else
    {
        $query2 = 'UPDATE Userz SET Active = "' . $active . '" WHERE UserID = "' . $id . '"';
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
        $output2 = $util->convert_query_output($output2, "Success");
        echo(json_encode($output2));
        exit();
    }
}

/**
 * Adds new conditions for the Stock2Shop push to the Database
 * @return void
 */
function put_cond_add(connect $connection, util $util, array $params)
{
    if(isset($_SESSION['connection']))
    {
        $credentials = $_SESSION['connection']->credentials;
        $rawConnection = $connection->createConnection($credentials->username, $credentials->password, $credentials->host, $credentials->dbname)->rawValue;
        $query = 'SELECT * FROM Conditions';
        $output = $connection->converterObject($rawConnection, $query);
        $output = $output->result;
        if(sizeof($output) == 0)
        {
            //no conditions exists in table
            $dataValue = $params['dataValue'];
            $condition = $params['statement'];
            $value = $params['value'];
            $query = "INSERT INTO Conditions
            (
                DataValue, 
                Statement, 
                Value
            )
            VALUES
            (
                '$dataValue', 
                '$condition', 
                '$value'
            )";
            $output = $connection->converterObject($rawConnection, $query);
            $output = $util->convert_query_output($output, "Success");
            echo(json_encode($output));
            mysqli_close($rawConnection);
            exit();
        }
        else
        {
            $condition1 = json_decode(json_encode($params, true));
            if($util->compareCondition($condition1, $output[0]))
            {
                $output = new \stdClass();
                $output->return = false;
                $output->body = 'Condition already exists';
                echo(json_encode($output));
                exit();
            }
            else
            {
                $dataValue = $params['dataValue'];
                $condition = $params['statement'];
                $value = $params['value'];
                $query = "INSERT INTO Conditions
                (
                    DataValue, 
                    Statement, 
                    Value
                )
                VALUES
                (
                    '$dataValue', 
                    '$condition',
                    '$value'
                )"
                ;
                $output = $connection->converterObject($rawConnection, $query);
                $output = $util->convert_query_output($output, "Success");
                echo(json_encode($output));
                mysqli_close($rawConnection);
                exit();
            }
        }
    }
}

/**
 * Removes a condition from the Database
 * @return void 
 */
function put_cond_del(connect $connection, util $util, array $params)
{
    if(isset($_SESSION['connection']))
    {
        $credentials = $_SESSION['connection']->credentials;
        $rawConnection = $connection->createConnection($credentials->username, $credentials->password, $credentials->host, $credentials->dbname)->rawValue;
        $query = 'SELECT * FROM Conditions';
        $output = $connection->converterObject($rawConnection, $query);
        $output = $output->result;
        if(sizeof($output) == 0)
        {
            $output = new \stdClass();
            $output->return = false;
            $output->body = 'No Conditions found';
            echo(json_encode($output));
            exit();
        }
        else
        {
            $dataValue = $params['dataValue'];
            $condition = $params['statement'];
            $value = $params['value'];
            $query = "DELETE FROM Conditions WHERE 
            DataValue = '$dataValue' &&
            Statement = '$condition' && 
            Value = '$value'";
            $output = $connection->converterObject($rawConnection, $query);
            $output = $util->convert_query_output($output, "Condition Removed");
            echo(json_encode($output));
            mysqli_close($rawConnection);
        }
    }
}
?>