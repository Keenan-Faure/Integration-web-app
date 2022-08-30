<?php

namespace pImport;

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

Class pImport
{
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
    function importProduct($fileToUse)
    {
        $containHeaders = true;
        $directory = 'uploads/';
        $file = scandir($directory);

        $output = new \stdClass();
        $output->existingProductsUpdated = 0;
        $output->newProductsAdded = 0;
        $output->rowsProcessed = 0;
        $output->productsSkipped = 0;

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
            $util = new util();
            $openFile = fopen($directory, 'r');
            $variable = new \stdClass();
            while(!feof($openFile))
            {
                $output->rowsProcessed = $output->rowsProcessed + 1;
                if($containHeaders == true)
                {
                    $containHeaders = false;
                    $headers = fgetcsv($openFile);
                    $productTemplate = array('active', 'title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'costPrice', 'sellingPrice',
                    'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3');

                    for($i = 0; $i < sizeof($headers); ++$i)
                    {
                        $headers[$i] = ltrim(rtrim($headers[$i]));
                        if(!in_array($headers[$i], $productTemplate))
                        {
                            $variable = new \stdClass();
                            $variable->return = false;
                            $variable->message = 'Unknown column header ' . $headers[$i];
                            $this->deleteFile($fileToUse);
                            return $variable;
                            exit();
                        }
                        else if(in_array(ltrim(rtrim($headers[$i])), $productTemplate))
                        {
                            //strips the spaces
                            $headers[$i] = ltrim(rtrim($headers[$i]));
                        }
                    }
                    for($i = 0; $i < sizeof($productTemplate); ++$i)
                    {
                        if(in_array($productTemplate[$i], $headers))
                        {
                            $template[$productTemplate[$i]] = array_keys($headers, $productTemplate[$i])[0];
                        }
                    }
                    //checkRequired headers
                    $check = $util->checkRequiredH($template);
                    if($check->result == false)
                    {
                        $variable = new \stdClass();
                        $variable->return = false;
                        $variable->message = $check->header . ' header not defined';
                        $this->deleteFile($fileToUse);
                        return $variable;
                        exit();
                    }
                    //gets the array key where the headers are defined
                    
                }
                //create product and add it to the database
                //check if the product exists already, if it does then just update the values
                $rawValue = fgetcsv($openFile);
                $connection2 = new connect();

                //add the errors in the logs using IO_logs
                $Log = new \stdClass();
                $IO_logs = array();

                $rawConnection = $connection2->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                if(isset($rawValue[$template['sku']]))
                {
                    $sku = ltrim(rtrim($rawValue[$template['sku']])); 

                    //gets the SKU
                    $query2 = "select * from Inventory where SKU = '" . $sku .  "'";
                    
                    $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
                    if($output2->result == null)
                    {
                        //creates the product with available headers
                        //sets undefined values to null
                        $Product = new \stdClass();
                        for($i = 0; $i < sizeof($headers); ++$i)
                        {
                            $index = array_keys($template, $i)[0];
                            if(isset($rawValue[$template[array_keys($template, $i)[0]]]))
                            {
                                $Product->$index = ltrim(rtrim($rawValue[$template[array_keys($template, $i)[0]]]));
                            }
                            else
                            {
                                $Product->$index = null;
                            }
                        }
                        $check = $util->checkRequired($Product);
                        if($check->result == false)
                        {
                            $variable = new \stdClass();
                            $variable->return = false;
                            $variable->message = $check->header . ' data value null or empty';
                            return $variable;
                        }
                        //check if the value is set
                        
                        $Product = json_decode(json_encode($Product), true);
                        //variable product
                        if(isset($Product['optionName']) && isset($Product['optionValue']))
                        {
                            $product = new vproduct();
                            $result = $product->createProduct($Product, $util, $connection2);
                            if(isset($result->return))
                            {
                                $output->productsSkipped = $output->productsSkipped + 1;
                                array_push($IO_logs, $result);
                                continue;
                            }
                            $output->newProductsAdded = $output->newProductsAdded + 1;
                            $result = $product->addProduct($result, $connection2);
                        }
                        //simple product
                        else
                        {
                            //simple product
                            $product = new sproduct();
                            $result = $product->createProduct($Product, $util, $connection2);
                            if(isset($result->return))
                            {
                                $output->productsSkipped = $output->productsSkipped + 1;
                                array_push($IO_logs, $result);
                                continue;
                            }
                            $output->newProductsAdded = $output->newProductsAdded + 1;
                            $result = $product->addProduct($result, $connection2);
                        }
                    }
                    //otherwise we must edit the existing product and update its values
                    else
                    {
                        //UPDATE
                        //creates the product with available headers
                        //sets undefined values to null
                        $Product = new \stdClass();
                        for($i = 0; $i < sizeof($headers); ++$i)
                        {
                            $index = array_keys($template, $i)[0];
                            if(isset($rawValue[$template[array_keys($template, $i)[0]]]))
                            {
                                $Product->$index = ltrim(rtrim($rawValue[$template[array_keys($template, $i)[0]]]));
                            }
                            else
                            {
                                $Product->$index = null;
                            }
                            
                        }

                        $check = $util->checkRequired($Product);
                        if($check->result == false)
                        {
                            $variable = new \stdClass();
                            $variable->return = false;
                            $variable->message = $check->header . ' data value null or empty';
                            return $variable;
                            break;
                        }
                        //check if the value is set
                        
                        $Product = json_decode(json_encode($Product), true);

                        //variable product
                        if(isset($Product['optionName']) && isset($Product['optionValue']))
                        {
                            $product = new vproduct();
                            $result = $product->createProduct($Product, $util, $connection2, 'edit');
                            if(isset($result->return))
                            {
                                $output->productsSkipped = $output->productsSkipped + 1;
                                array_push($IO_logs, $result);
                                continue;
                            }
                            $output->existingProductsUpdated = $output->existingProductsUpdated + 1;
                            $result = $product->updateProduct($result, $util, $connection2);
                        }
                        //simple product
                        else
                        {
                            //simple product
                            $product = new sproduct();
                            $result = $product->createProduct($Product, $util, $connection2, 'edit');
                            if(isset($result->return))
                            {
                                $output->productsSkipped = $output->productsSkipped + 1;
                                array_push($IO_logs, $result);
                                continue;
                            }
                            $output->existingProductsUpdated = $output->existingProductsUpdated + 1;
                            $result = $product->updateProduct($result, $util, $connection2);
                        }

                    }
                }
            }
            $Log->ImportProducts = $IO_logs;
            array_push($_SESSION['log'], $Log);
        }
        fclose($openFile);
        mysqli_close($rawConnection);
        $this->deleteFile($fileToUse);
        $result = new \stdClass();
        $result->result = $output;
        return $result;
    }
}
?>