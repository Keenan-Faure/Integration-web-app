<?php

namespace pExport;

session_start();
include('../createConnection.php');

use Connection\Connection as connect;

Class pExport
{
    //uses the createFile and getProducts output as parameters
    function writeOutput($products = array())
    {
        $headers = array('Token', 'Type', 'Active', 'Grouping Code', 'Title', 'Description', 'Sku', 'Category', 'Product Type', 'Brand', 'Variant Code', 'Barcode', 'Weight', 
        'Cost Price', 'Selling Price', 'Quantity', 'Option Name', 'Option Value', 'Option2Name', 'Option2Value', 'Meta1', 'Meta2', 'Meta3');

        $name = 'Product Export.csv';
        if(isset($_SESSION['connection']))
        {
            $database = $_SESSION['connection']->credentials->dbname;
            
            $name = 'Product Export.csv';
            $myFile = fopen($name, 'w');
            
            //writes the headers first
            fputcsv($myFile, $headers);

            $products = $this->getProducts();
            if($products != null)
            {
                for($i = 0; $i < sizeof($products); ++$i)
                {
                    $products[$i]['Description'] = htmlspecialchars_decode($products[$i]['Description']);
                    fputcsv($myFile, $products[$i]);
                }
            }
            fclose($myFile);
        }
        $this->downloadFile();
        $this->deleteFile($myFile);
    }
    function deleteFile($file)
    {
        $dir = 'uploads/';
        $filer = scandir($dir);
        if(in_array($file, $filer))
        {
            $file = $dir . $file;
            unlink($file);
        }
    }
    function getProducts()
    {
        $connection = new connect();
        $conn = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password,'localhost',$_SESSION['connection']->credentials->dbname);
        $query = 'select * from Inventory';
        $output = $this->createProductArray($conn->rawValue, $query);
        return $output->result;
    }
    function downloadFile()
    {
        $fileurl = 'Product Export.csv';
        header("Content-type:application/csv");
        header('Content-Disposition: attachment; filename=' . $fileurl);
        readfile($fileurl);
    }
    function createProductArray($rawConnection, $query)
    {
        $resultArray = array();
        $output = array();
        $duration = 0;
        $variable = null;
        $starttime = microtime(true);
        try
        {
            if($result = mysqli_query($rawConnection, $query))
            {
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
                $array = array();
                if(is_bool($result))
                {
                    if($result)
                    {
                        $variable = new \stdClass();
                        $variable->result = true;
                        $variable->query = $query;
                        $variable->duration = $duration;
                    }
                }
                else
                {
                    while($row = $result->fetch_object())
                    {
                        //converts it into a php array
                        if(isset($row->Description))
                        {
                            $var = htmlspecialchars($row->Description);
                            $row->Description = $var;
                        }
                        $array = json_decode(json_encode($row), true);
                        array_push($resultArray, $array);
                    }
                    $variable = new \stdClass();
                    $variable->result = $resultArray;
                }
            }
            else
            {
                $variable = new \stdClass();
                $variable->result = new \stdClass();
                $variable->result = null;
                $variable->query = $query;
                $variable->query_time = $duration;
            }
        }
        catch(\Exception $error)
        {
            $variable = new \stdClass();
            $variable->error = $error->getMessage();
            $variable->query = $query;
            $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        }
        return $variable;
    }
}

$export = new pExport();
$export->writeOutput();
?>