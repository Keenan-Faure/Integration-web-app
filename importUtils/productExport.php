<?php

namespace pExport;

session_start();
include('../Class Templates/createConnection.php');

use Connection\Connection as connect;

Class pExport
{
    //uses the createFile and getProducts output as parameters
    /**
     * Creates and writes all products into a csv file
     */
    function writeOutput()
    {
        $products = array();
        $headers = array('active', 'sku', 'title', 'description', 'groupingCode', 'category', 'productType', 'brand', 'variantCode', 'barcode', 'weight', 
        'comparePrice', 'sellingPrice', 'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3');

        $name = 'Product Export.csv';
        if(isset($_SESSION['connection']))
        {
            $_SESSION['connection']->credentials->dbname;
            
            $name = 'Product Export.csv';
            $myFile = fopen($name, 'w');
            
            //writes the headers first
            fputcsv($myFile, $headers);

            $products = $this->getProducts();
            if($products != null)
            {
                for($i = 0; $i < sizeof($products); ++$i)
                {
                    $products[$i]->Description = stripslashes(htmlspecialchars_decode($products[$i]->Description));
                    fputcsv($myFile, json_decode(json_encode($products[$i]), true));
                }
            }
            fclose($myFile);
            $this->downloadFile();
            $this->deleteFile($name);
        }
    }
    /**
     * Deletes the file from the server
     */
    function deleteFile($file)
    {
        $dir = './';
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
        $query = 'SELECT 
         Active,
         SKU,
         Title,
         Description,
         Group_Code,
         Category,
         Product_Type,
         Brand,
         Variant_Code,
         Barcode,
         Weight,
         ComparePrice,
         SellingPrice,
         CapeTown_Warehouse,
         Option_1_Name,
         Option_1_Value,
         Option_2_Name,
         Option_2_Value,
         Meta_1,
         Meta_2,
         Meta_3
         FROM Inventory';
        $output = $connection->converterObject($conn->rawValue, $query);
        return $output->result;
    }

    /**
     * downloads the file from the server
     */
    function downloadFile()
    {
        $fileurl = 'Product Export.csv';
        header("Content-type:application/csv");
        header('Content-Disposition: attachment; filename=' . $fileurl);
        readfile($fileurl);
    }
}

$export = new pExport();
$export->writeOutput();
?>