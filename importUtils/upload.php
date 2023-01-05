<?php

session_start();
include("productImport.php");
include("customerImport.php");
include("../Class Templates/vProduct.php");
include("../Class Templates/sProduct.php");
include("../Class Templates/utility.php");
include('../Class Templates/createConnection.php');
$_config = include('../config/config.php');

use utils\Utility as util;
use sProducts\sProducts as sproduct;
use vProducts\vProducts as vproduct;
use Connection\Connection as connect;

use pImport\pImport as import;

if(!isset($_SESSION['connection']))
{
    if(isset($_SESSION['log']))
    {
        $conn->addLogs('No Connection found', 'No connection found in current session, please re-connect', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'info', false, $_config);
    }
    $conn->createHtmlMessages('', 'Error connecting to user session', 'No connection found in current session, please re-connect', 'login', 'info');
    header("Refresh:2,url=../auth/login.php");
    exit();
}

$targetDirectory = 'uploads/'; //folder must exist
$targetFile = $targetDirectory . basename($_FILES['file']['name']); //its an array

$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

if(isset($_POST['submit']))
{
    $conn = new connect();
    $sproduct = new sproduct();
    $vproduct = new vproduct();
    $util = new util();
    $import = new import();

    $file = new \stdClass();
    $file->fileName = basename($_FILES['file']['name']);
    $file->path = $targetDirectory . basename($_FILES['file']['name']);
    $file->extension = "." . strtolower(pathinfo($file->fileName, PATHINFO_EXTENSION));
    if($file->fileName != null)
    {
        if($file->extension != '.csv')
        {
            $conn->createHtmlMessages('', 'File Upload', 'Unsupported file type. Only csv format allowed.', '../ImportUtils/productImport', 'info');
            exit();
        }
        if(file_exists($file->path))
        {
            $conn->createHtmlMessages('', 'File Upload', 'File already exists', '../ImportUtils/productImport', 'info');
            exit();
        }
        if($_FILES["file"]["size"] > 10000000)
        {
            $conn->createHtmlMessages('', 'File Upload', 'File size exceeded 10Mb', '../ImportUtils/productImport', 'info');
            exit();
        }
        $check = getimagesize($_FILES['file']['tmp_name']);

        //uploadsFile     
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) 
        {
            $result = $import->importProduct($file->fileName, $conn, $util, $vproduct, $sproduct);
            $conn->createJsonMessages('File Upload', json_encode($result, JSON_PRETTY_PRINT), '../ImportUtils/import', 'info');
            //header('Refresh:2,url=import.html');
            exit();
        } 
        else 
        {
            $conn->createHtmlMessages('', 'File Upload', 'File has been uploaded successfully', '../ImportUtils/import', 'info');
            header('Refresh:2,url=import.html');
            exit();
        }
    }
    else
    {
        $conn->createHtmlMessages('', 'File Upload', 'Invalid File', '../ImportUtils/import.html', 'info');
        header('Refresh:2,url=import.html');
        exit();
    }
}
else
{
    $conn->createHtmlMessages('', 'File Upload', 'Unknown error occurred, please try again', '../ImportUtils/import', 'info');
    header('Refresh:2,url=import.html');
    exit();
}

?>

