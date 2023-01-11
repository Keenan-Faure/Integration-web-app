<?php

namespace pImport;

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
    function importProduct($fileToUse, $conn, $util, $vproduct, $sproduct)
    {
        $_config = include('../config/config.php');
        $containHeaders = true;
        $directory = 'uploads/';
        $file = scandir($directory);

        $output = new \stdClass();
        $output->existingProductsUpdated = 0;
        $output->newProductsAdded = 0;
        $output->rowsProcessed = 0;
        $output->productsSkipped = 0;
        $undefinedHeaders = array();
        $template = array();

        if(isset($file))
        {
            if(sizeof($file) < 3)
            {
                $conn->createHtmlMessages('', 'File Upload', 'Empty Directory', '../ImportUtils/import.html', 'info');
                header('Refresh:2,url=import.html');
                exit();
            }
        }
        $directory = $directory . $fileToUse;
        if(in_array($fileToUse, $file))
        {
            $openFile = fopen($directory, 'r');
            $variable = new \stdClass();
            while(!feof($openFile))
            {
                $output->rowsProcessed = $output->rowsProcessed + 1;
                if($containHeaders == true)
                {
                    $containHeaders = false;
                    $headerS = fgetcsv($openFile);
                    $headers = array();
                    $productTemplate = array('active', 'title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'comparePrice', 'sellingPrice',
                    'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3');

                    for($i = 0; $i < sizeof($headerS); ++$i)
                    {
                        $head = ltrim(rtrim($headerS[$i]));
                        if(in_array($head, $productTemplate))
                        {
                            $headers[$i] = $head;
                        }
                        else
                        {
                            fclose($openFile);
                            $this->deleteFile($fileToUse);
                            $var = new \stdClass();
                            $var->return = false;
                            $var->message = 'Undefined header "' . $headerS[$i] . '"';
                            return $var;
                            exit();
                        }
                    }
                    for($i = 0; $i < sizeof($productTemplate); ++$i)
                    {
                        if(in_array($productTemplate[$i], $headers))
                        {
                            $template[$productTemplate[$i]] = array_keys($headers, $productTemplate[$i])[0];
                        }
                        else
                        {
                            array_push($undefinedHeaders, $productTemplate[$i]);
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
                }
                //create product and add it to the database
                //check if the product exists already, if it does then just update the values
                $rawValue = fgetcsv($openFile);

                $rawConnection = $conn->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                if(isset($rawValue[$template['sku']]))
                {
                    $sku = ltrim(rtrim($rawValue[$template['sku']])); 

                    //gets the SKU
                    $query2 = "SELECT * FROM Inventory WHERE SKU = '" . $sku .  "'";
                    $output2 = $conn->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
                    if($output2->result == null)
                    {
                        //creates the product with available headers
                        //sets undefined values to null
                        $Product = new \stdClass();


                        //ignores all the undefined headers found at the bottom
                        //of the headers array and starts the index at the 
                        //first defined index
                        $min = min($template);

                        for($i = $min; $i < sizeof($template) + $min; ++$i)
                        {
                            //because it uses the keys (the numbers) we cant set anything.
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

                        //sets undefinedHeaders values to null
                        for($i = 0; $i < sizeof($undefinedHeaders); ++$i)
                        {
                            $variable = $undefinedHeaders[$i];
                            $Product->$variable = null;
                        }
                        $check = $util->checkRequired($Product);
                        if($check->result == false)
                        {
                            $variable = new \stdClass();
                            $variable->return = false;
                            $variable->message = $check->header . ' data value null or empty';
                            return $variable;
                        }
                        
                        $Product = json_decode(json_encode($Product), true);
                        //variable product
                        if($Product['optionName'] != null && $Product['optionValue'] != null)
                        {
                            $result = $vproduct->createProduct($Product, $util, $conn);
                            if(isset($result->return))
                            {
                                $output->productsSkipped = $output->productsSkipped + 1;
                                $conn->addLogs('Import product', 'Product Skipped: "' . $Product['sku'] . '"', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);
                                continue;
                            }
                            $output->newProductsAdded = $output->newProductsAdded + 1;
                            $result = $vproduct->addProduct($result, $conn);
                            if(!isset($result->data))
                            {
                                $conn->addLogs('Add Product Failed:', 'Product: "' . $Product['sku'] . '"', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);
                            }
                        }
                        //simple product
                        else
                        {
                            //simple product
                            $result = $sproduct->createProduct($Product, $util, $conn);
                            if(isset($result->return))
                            {
                                $output->productsSkipped = $output->productsSkipped + 1;
                                $conn->addLogs('Import product', 'Product Skipped: "' . $Product['sku'] . '"', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);
                                continue;
                            }
                            $output->newProductsAdded = $output->newProductsAdded + 1;
                            $result = $sproduct->addProduct($result, $conn);
                            if(!isset($result->data))
                            {
                                $conn->addLogs('Add Product Failed:', 'Product: "' . $Product['sku'] . '"', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);
                            }
                        }
                    }
                    //otherwise we must edit the existing product and update its values
                    else
                    {
                        //UPDATE
                        //creates the product with available headers
                        //sets undefined values to null
                        $Product = new \stdClass();

                        //ignores all the undefined headers found at the bottom
                        //of the headers array and starts the index at the 
                        //first defined index
                        $min = min($template);

                        for($i = $min; $i < sizeof($headers) + $min; ++$i)
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
                        //sets undefined headers values to null
                        for($i = 0; $i < sizeof($undefinedHeaders); ++$i)
                        {
                            $variable = $undefinedHeaders[$i];
                            $Product->$variable = null;
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
                        if($Product['optionName'] != null && $Product['optionValue'] != null)
                        {
                            $result = $vproduct->createProduct($Product, $util, $conn, 'edit');
                            if(isset($result->return))
                            {
                                $output->productsSkipped = $output->productsSkipped + 1;
                                $conn->addLogs('Import product', 'Product Skipped: "' . $Product['sku'] . '"', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);
                                continue;
                            }
                            $output->existingProductsUpdated = $output->existingProductsUpdated + 1;
                            $result = $vproduct->updateProduct($result, $util, $conn);
                            if(!isset($result->data))
                            {
                                $conn->addLogs('Update Failed:', 'Product: "' . $Product['sku'] . '"', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);
                            }
                        }
                        //simple product
                        else
                        {
                            //simple product
                            $result = $sproduct->createProduct($Product, $util, $conn, 'edit');
                            if(isset($result->return))
                            {
                                $output->productsSkipped = $output->productsSkipped + 1;
                                $conn->addLogs('Import Product', 'Product Skipped: "' . $Product['sku'] . '"', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);
                                continue;
                            }
                            $output->existingProductsUpdated = $output->existingProductsUpdated + 1;
                            $result = $sproduct->updateProduct($result, $util, $conn);
                            if(!isset($result->data))
                            {
                                $conn->addLogs('Update Failed:', 'Product: "' . $Product['sku'] . '"', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);
                            }
                        }

                    }
                }
            }
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