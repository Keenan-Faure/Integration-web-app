<?php

namespace pExport;

session_start();

include('../Class Templates/customer.php');
include('../Class Templates/sProduct.php');
include('../Class Templates/vProduct.php');
include('../Class Templates/utility.php');
include('../createConnection.php');

use utils\Utility as util;
use sProducts\sProducts as sproduct;
use vProducts\vProducts as vproduct;
use customer\Customers as customer;
use Connection\Connection as connect;

Class pExport
{
    //creates a connection
    //then gets all the products in the database - ALL
    //returns an array
    function getProducts()
    {
        $connection = new connect();
        $conn = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password,'localhost',$_SESSION['connection']->credentials->dbname);
        $query = 'select * from Inventory';
        $output = $connection->converterObject($conn->rawValue, $query);
        print_r($output);
    }
    //uses the createFile and getProducts output as parameters
    function writeOutput($products = array())
    {
        $database = $_SESSION['connection']->credentials->dbname;
        $myFile = fopen($database . ' - product export - ' . date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'w');
        


        fclose($myFile);
    }
    function exportProducts()
    {
        if(isset($_SESSION['connection']))
        {
            //
        }
    }
}

?>