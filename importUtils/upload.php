<?php

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
        if($file->extension != 'csv')
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
        print_r($_FILES["file"]["tmp_name"]);
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
        {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } 
        else 
        {
            echo "Sorry, there was an error uploading your file.";
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