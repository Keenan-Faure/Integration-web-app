<?php

session_start();
include("productImport.php");
include("customerImport.php");

use pImport\pImport as import;

if(!isset($_SESSION['connection']))
{
    $variable = new \stdClass();
    $variable->active = false;
    $variable->message = 'No connection found in current session, please re-connect';
    $variable->failedPage = 'productImport.php';
    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
    if(isset($_SESSION['log']))
    {
        array_push($_SESSION['log'], $variable);
    }
    echo(json_encode($variable));
    header("Refresh:2,url=../login.php");
    exit();
}

$targetDirectory = 'uploads/'; //folder must exist
$targetFile = $targetDirectory . basename($_FILES['file']['name']); //its an array

$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

if(isset($_POST['submit']))
{
    $file = new \stdClass();
    $file->fileName = basename($_FILES['file']['name']);
    $file->path = $targetDirectory . basename($_FILES['file']['name']);
    $file->extension = "." . strtolower(pathinfo($file->fileName, PATHINFO_EXTENSION));
    if($file->fileName != null)
    {
        if($file->extension != '.csv')
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->file = $file;
            $variable->message = 'Unsupported file type. Only csv format allowed.';
            print_r(json_encode($variable));
            return $variable;
        }
        if(file_exists($file->path))
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->file = $file;
            $variable->message = 'File already exists';
            print_r(json_encode($variable));
            return $variable;
        }
        if($_FILES["file"]["size"] > 10000000)
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->file = $file;
            $variable->message = 'File size exceeds 10mb';
            print_r(json_encode($variable));
            return $variable;
            
        }
        $check = getimagesize($_FILES['file']['tmp_name']);

        //uploadsFile     
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) 
        {
            $variable = new \stdClass();
            $variable->return = true;
            $variable->file = $file;
            $variable->message = $_FILES['file']['name'] . ' has been successfully uploaded';
            $import = new import();
            $result = $import->importProduct($variable->file->fileName);
            print_r(json_encode($result));
            return $variable;
        } 
        else 
        {
            $variable = new \stdClass();
            $variable->return = false;
            $variable->file = $file;
            $variable->message = $_FILES['file']['name'] . ' could not be uploaded.';
            print_r(json_encode($variable));
            return $variable;
        }
    }
    else
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->file = $file;
        $variable->message = 'Invalid File';
        print_r(json_encode($variable));
    }
}
else
{
    $variable = new \stdClass();
    $variable->return = false;
    $variable->message = 'Unknown error occured, please retry';
    print_r(json_encode($variable));
}

?>

