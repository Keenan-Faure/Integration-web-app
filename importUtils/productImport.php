<?php

$fileToUse = 'operaPasswords.csv';
$containHeaders = true;

$directory = 'Uploads/';

$file = scandir($directory);

if(isset($file))
{
    if(sizeof($file) < 3)
    {
        $variable = new \stdClass();
        $variable->return = false;
        $variable->message = "Empty Directory";
        print_r(json_encode($variable));
        exit();
    }
}
$directory = $directory . $fileToUse;
if(in_array($fileToUse, $file))
{
    $openFile = fopen($directory, 'r');
    while(!feof($openFile))
    {
        if($containHeaders == true)
        {
            $containHeaders = false;
            $headers = explode(',', fgets($openFile));

            $productTemplate = array('active', 'title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'costPrice', 'sellingPrice',
            'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3');

            for($i = 0; $i < sizeof($headers); ++$i)
            {
                if(!in_array(ltrim(rtrim($headers[$i])), $productTemplate))
                {
                    print_r($headers[$i] . " not in product template");
                    $variable = new \stdClass();
                    $variable->return = false;
                    $variable->message = 'Unknown column header ' . $headers[$i];
                    break;
                }
            }
            for($i = 0; $i < sizeof($productTemplate); ++$i)
            {
                if(in_array($productTemplate[$i], $headers))
                {
                    $template[$productTemplate[$i]] = array_keys($headers, $productTemplate[$i])[0];
                }
            }
            
            //gets the array key where the headers are defined
            print_r($template);
            break;
        }
        //create product and add it to the database
        //check if the product exists already, if it does then just update the values
        $rawValue = explode(',', fgets($openFile));
        print_r($rawValue);
        break;
    }
}

fclose($openFile);

?>