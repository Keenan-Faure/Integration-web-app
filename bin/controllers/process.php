<?php
session_start();
include("../../Class Templates/vProduct.php");
include("../../Class Templates/sProduct.php");
include("../../Class Templates/customer.php");
include("../../Class Templates/utility.php");
include('../../Class Templates/createConnection.php');

use sProducts\sProducts as sproduct;
use vProducts\vProducts as vproduct;
use customer\Customers as customer;
use utils\Utility as util;
use Connection\Connection as connect;
header("Content-Type: application/json");

if(isset($_SESSION['clientConn']) && isset($_SESSION['connection']))
{
    if($_SESSION['clientConn']->active == true)
    {

        if($_SESSION['connection']->active == true)
        {
            $util = new util();
            $connection = new connect();
            if(isset($_POST['name']) && isset($_POST['surname']))
            {
                //customer
                $customer = new customer();
                $result = $customer->createCustomer($_POST, $util, $connection);
                if(isset($result->return))
                {
                    echo(json_encode($result));
                    header('Refresh:2,url=endpoints.php');
                    unset($_POST);
                    exit();
                }
                $result = $customer->addCustomer($result, $connection);
                echo(json_encode($result));
                unset($_POST);
                header('Refresh:2,url=endpoints.php');
            }
            else if(!isset($_POST['name']) && !isset($_POST['surname']))
            {
                if($_SESSION['settings']->App_settings->app_add_products != 'true')
                {
                    $connection->createHtmlMessages('', 'Add Products disabled', 'Please contact admin', 'endpoints', 'info');
                    exit();
                }
                if(isset($_POST['optionName']) && isset($_POST['optionValue']))
                {
                    $product = new vproduct();
                    $result = $product->createProduct($_POST, $util, $connection);
                    if(isset($result->return))
                    {
                        echo(json_encode($result));
                        header('Refresh:2,url=productList.php?page=1');
                        unset($_POST);
                        exit();
                    }
                    $result = $product->addProduct($result, $connection);
                    echo(json_encode($result));
                    unset($_POST);
                    header('Refresh:2,url=productList.php?page=1');
                }
                else
                {
                    //simple product
                    
                    $product = new sproduct();
                    $result = $product->createProduct($_POST, $util, $connection);
                    if(isset($result->return))
                    {
                        echo(json_encode($result));
                        header('Refresh:2,url=productList.php?page=1');
                        unset($_POST);
                        exit();
                    }
                    $result = $product->addProduct($result, $connection);
                    echo(json_encode($result));
                    unset($_POST);
                    header('Refresh:2,url=productList.php?page=1');
                }
            }
            else
            {
                $conn = new connect();
                $conn->addLogs('Error loading post data', 'No POST Data found, please re-select', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true);
                $conn->createHtmlMessages('', 'Error: Post Data', 'Error loading post data', 'endpoints', 'warn');
                header('Refresh:2,url=productList.php?page=1');
            }
        }
        else
        {
            $conn = new connect();
            $conn->addLogs('Error connecting', 'No connection found in current session, please re-connect', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', false);
            $conn->createHtmlMessages('', 'Error connecting', 'No Session was detected', 'login', 'info');

            header('Refresh:2,url=../../auth/login.php');
        }
    }
    else
    {
        $conn = new connect();
        $conn->addLogs('Error connecting', 'No login data found for current user', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', false);
        $conn->createHtmlMessages('', 'Error connecting to user session', 'No Session User was detected', 'login', 'info');
        header('Refresh:2,url=../../auth/login.php');
    }
}
else
{
    $conn = new connect();
    $conn->addLogs('Error connecting', 'No login data found for current user', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', false);
    $conn->createHtmlMessages('', 'Error connecting to user session', 'No Session User was detected', 'login', 'info');
    header('Refresh:2,url=../../auth/login.php');
}

?>