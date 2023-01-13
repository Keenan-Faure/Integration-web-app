<?php
    
session_start();

$_SESSION['s2s_push_status'] = new \stdClass();
if(!isset($_SESSION['pushVariable']))
{
    $_SESSION['pushVariable'] = array();
}

include("cURL.php");
include("../Class Templates/createConnection.php");
include("../Class Templates/utility.php");
$_config = include('../config/config.php');
use Connection\Connection as connect;
use cURL\CURL as curl;
use utils\Utility as util;

$connection = new connect();
$util = new util();
$curl = new curl();

if(isset($_SESSION['connection']))
{
    if($_SESSION['connection']->active == true)
    {
        $products = get_prod_s2s($connection, $util);
        push_s2s($products, $connection, $curl, $_config);
    }
}
else
{
    $_SESSION['s2s_push_status']->return = false;
    $_SESSION['s2s_push_status']->message = 'No Session found';
}

/**
 * Queries the data to return all the products that are eligible to push to Stock2Shop
 */
function get_prod_s2s($connection, $util)
{
    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
    $conditions = $connection->converterObject($rawConnection, "SELECT * FROM Conditions", $_SESSION['connection']->credentials->dbname);
    $query2 = 'SELECT inv.SKU FROM Inventory inv INNER JOIN Stock2Shop s2s ON inv.SKU = s2s.SKU WHERE inv.Audit_Date > s2s.pushDate AND Active = "true"';
    $query2 = $util->createQuery($conditions, $query2);
    
    $output2 = $connection->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
    $result = $output2->result;
    return $result;
}

/**
 * Pushes products to Stock2Shop
 * @param array $products Array of products to push to Stock2Shop
 * @param connection $connection 
 * @param curl $curl
 * @param array $_config config file
 */
function push_s2s($products, $connection, $curl, $_config)
{
    $_SESSION['s2s_push_status']->return = true;
    $_SESSION['s2s_push_status']->message = 'Push was Initialized';
    if(sizeof($products) > 0)
    {
        $_SESSION['s2s_push_status']->data = $products;
    }
    echo(json_encode($_SESSION['s2s_push_status']));

    if($_SESSION['settings']->S2S_settings->s2s_add_products != 'true')
    {
        $_SESSION['s2s_push_status']->return = false;
        $_SESSION['s2s_push_status']->message = 'Push Products disabled';
        exit();
    }
    $_SESSION['s2s_push_status']->message = "Check 1/2";
    if(!isset($_SESSION['token']))
    {
        $_SESSION['s2s_push_status']->return = false;
        $_SESSION['s2s_push_status']->message = 'No Authentication token found in current session';
        exit();
    }  
    $_SESSION['s2s_push_status']->message = "Check 2/2";      

    //Should not depend on param anymore
    $limit = sizeof($products);
    if($limit == 0)
    {
        $_SESSION['s2s_push_status']->return = true;
        $_SESSION['s2s_push_status']->message = 'Push Complete';
        exit();
    }

    for($i = 0; $i < $limit; ++$i)
    {
        $sku = $products[$i]->SKU;

        $_SESSION['s2s_push_status']->message = "Pushing '" . $sku . "' - " .($i+1) . "/" . $limit;

        if($sku == '')
        {
            $_SESSION['s2s_push_status']->return = false;
            $_SESSION['s2s_push_status']->message = 'Attempting to query NULL SKU';
            exit();
        }

        array_push($_SESSION['pushVariable'], $sku);

        //if session variable of pushVariable > 20 or equal to the limit
        //then we proceed with the push
        if(sizeof($_SESSION['pushVariable']) > 9 || sizeof($_SESSION['pushVariable']) == $limit)
        {
            $username = $_SESSION['settings']->Stock2Shop_Credentials->s2s_user;
            $password = $_SESSION['settings']->Stock2Shop_Credentials->s2s_password;
            $token = $_SESSION['token'];

            $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
            $output = new \stdClass();
            $output->result = array();

            //loops through the entire array of products and adds them together
            for($i = 0; $i < sizeof($_SESSION['pushVariable']); ++$i)
            {
                $product = $connection->converterObject($rawConnection, 'SELECT * FROM Inventory WHERE SKU="' . $_SESSION['pushVariable'][$i] . '"')->result;
                $product[0]->Description = html_entity_decode($product[0]->Description);
                array_push($output->result, $product[0]);
            }
            unset($_SESSION['pushVariable']);

            //gets the source information, we'll only use the flatfile
            if(!isset($_SESSION['clientConn']->token))
            {
                $_SESSION['s2s_push_status']->result = false;
                $_SESSION['s2s_push_status']->message = 'No Authentication token found in session';
                exit();
            }

            $sources = ($curl->getSources($token,$username, $password));
            if($sources->httpcode == '200')
            {
                $pushed = new \stdClass();
                $pushed->system_products = array();

                for($i = 0; $i < sizeof($output->result); ++$i)
                {
                    //converts the description to HTML decodes, strips slashes
                    $output->result[$i]->Description = htmlspecialchars_decode(stripslashes($output->result[$i]->Description));
                    
                    $data = $curl->addProduct($output->result[$i], $sources->system_sources[0], $_SESSION['settings']);
                    if($data != null)
                    {
                        //update table Stock2Shop
                        $curl->insertStock2Shop($connection, $output->result[$i]->SKU, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']));
                        array_push($pushed->system_products, $data);
                    }
                    else
                    {
                        if(isset($_SESSION['log']))
                        {
                            $connection->addLogs('Push Product', "Product with SKU " . $output->result[$i]->SKU . " was not processed because of NULL Data", date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);
                        }
                    }
                }
                $curl->push($pushed, $sources->system_sources[0], $token, $username, $password);
                $_SESSION['s2s_push_status']->return = true;
                $_SESSION['s2s_push_status']->message = 'Push Complete';
                exit();
            }
            else
            {
                $curl->getSources($token,$username, $password);
            }
        }
    }
}
?>