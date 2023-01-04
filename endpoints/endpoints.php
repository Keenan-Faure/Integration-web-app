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
 * Description: Fetches IDs from Database. Uses inner join on Woocommerce & Inventory tables 
 * Request Type: GET
 * @Params: $connection & $params
 * @returns: \stdClass (object)
 */
function get_ids($connection, $util, $params)
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
 * Description: Search endpoint for products/orders/customers. Searches through the respective tables in the database
 * Request Type: GET
 * @Params: $connection & $params & $util
 * @returns: \stdClass (object)
 */
function get_search($connection, $util, $params)
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
 * Description: Gets the session, as a json object, and returns it
 * Request Type: GET
 * @Params: none used
 * @returns: \stdClass (object)
 */
function get_ses($connection, $util, $params)
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
 * Description: Gets all products in the Inventory table that:
 *      - That has a recent audit date
 *      - Is active to sync
 * Request Type: GET
 * @Params: $connection & $util (Not used) & $params 
 * @returns: \stdClass (object)
 */
function get_sku($connection, $util, $params)
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
        $query2 = 'SELECT inv.SKU FROM Inventory inv INNER JOIN Stock2Shop s2s ON inv.SKU = s2s.SKU WHERE inv.Audit_Date > s2s.pushDate AND Active = "true"';
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
 * Description: Gets all users in the Client table
 * Request Type: GET
 * @Params: $connection & $util (Not used) & $params 
 * @returns: \stdClass (object)
 */
function get_usz($connection, $util, $params)
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
 * Description: Updates the `Logs` table in the database
 * Request Type: PUT
 * @Params: $connection & $util (Not used) & $params 
 * @returns: \stdClass (object)
 */
function put_logs($connection, $util, $params)
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
        $variable = new \stdClass();
        $variable->result = $output2->result;
        if($output2->result != true)
        {
            $variable->body = 'Error Occured';
        }
        else
        {
            $variable->body = 'Success';
        }
        echo(json_encode($variable));
        exit();
    }
}

/**
 * Description: Updates the `Userz` table in the database
 * Request Type: PUT
 * @Params: $connection & $util (Not used) & $params 
 * @returns: \stdClass (object)
 */
function put_usz($connection, $util, $params)
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
        $variable = new \stdClass();
        $variable->result = $output2->result;
        if($output2->result != true)
        {
            $variable->body = 'Error Occured';
        }
        else
        {
            $variable->body = 'Success';
        }
        echo(json_encode($variable));
        exit();
    }
}
?>