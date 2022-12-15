<?php
    //replace all create HTML messages with json messages
    
    session_start();
    if(!isset($_SESSION['pushVariable']))
    {
        $_SESSION['pushVariable'] = array();
    }
    // unset($_SESSION['pushVariable']);
    // exit();
    include('cURL.php');
    include("../Class Templates/createConnection.php");
    use Connection\Connection as connect;
    use cURL\CURL as curl;
    if(isset($_SESSION['connection']))
    {
        if($_SESSION['connection']->active == true)
        {
            if($_SESSION['settings']->S2S_settings->s2s_add_products != 'true')
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->message = 'Push Products disabled';
                $variable->body = null;
                echo(json_encode($variable));
                //$connection->createHtmlMessages('Push Products disabled', 'Please contact admin', '/CURL/app', 'info');
                exit();
            }
            if(!isset($_SESSION['token']))
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->message = 'No Authentication token found in current session';
                echo(json_encode($variable));
                //$connection->createHtmlMessages('Push Products disabled', 'Please contact admin', '/CURL/app', 'info');
                exit();
            }
            $connection = new connect();
            
            //gets the SKU
            $host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
            $fullUrl = $_SERVER["REQUEST_URI"];
            $fullUrl = $host . $fullUrl;
            $params = ($connection->queryParams($fullUrl));
            if(sizeof($params) != 2)
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->message = 'No Param was entered';
                echo(json_encode($variable));
                exit();
            }
            $sku = $params['q'];
            $limit = $params['limit'];
            if($sku == '')
            {
                $variable = new \stdClass();
                $variable->result = false;
                $variable->message = 'Attempting to query NULL SKU';
                echo(json_encode($variable));
                exit();
            }

            array_push($_SESSION['pushVariable'], $sku);

            //if session variable of pushVariable > 20 or equal to the limit
            //then we proceed with the push
            if(sizeof($_SESSION['pushVariable']) > 20 || sizeof($_SESSION['pushVariable']) == $limit)
            {
                $curl = new curl();
                $username = $_SESSION['settings']->Stock2Shop_Credentials->s2s_user;
                $password = $_SESSION['settings']->Stock2Shop_Credentials->s2s_password;
                $token = $_SESSION['token'];

                $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $output = new \stdClass();
                $output->result = array();

                // $var = new \stdClass();
                // $var->msg=($_SESSION['pushVariable']);
                // echo(json_encode($var));
                // unset($_SESSION['pushVariable']);
                // exit();
                //loops through the entire array of products and adds them together
                for($i = 0; $i < sizeof($_SESSION['pushVariable']); ++$i)
                {
                    $product = $connection->converterObject($rawConnection, 'SELECT * FROM Inventory WHERE SKU="' . $_SESSION['pushVariable'][$i] . '"')->result;
                    $product[0]->Description = html_entity_decode($product[0]->Description);
                    array_push($output->result, $product[0]);
                }
                unset($_SESSION['pushVariable']);

                //gets the source information, we'll only use the flatfile
                if(!isset($_SESSION['clientConn']->token))
                {
                    $variable = new \stdClass();
                    $variable->result = false;
                    $variable->message = 'No Authentication token found in session';
                    $variable->body = null;
                    echo(json_encode($variable));
                    //$connection->createHtmlMessages('No Authentication token found in session', 'Please create token then try again', '/CURL/app', 'info');
                    exit();
                }

                //can be retrieved from S2S Settings
                $sources = ($curl->getSources($token,$username, $password));
                if($sources->httpcode == '200')
                {
                    $pushed = new \stdClass();
                    $pushed->system_products = array();
                    /////////////////////////////
                    /////////STOPS HERE//////////
                    /////////////////////////////

                    // - it stops because output is null (not defined)
                    // - solution would be to make it the same format as output
                    // - when you get the data for the SKUs from Database
                    // - output = new \stdClass()
                    // - output->result = array()  <-- Append all products inside there (Description/Title/SKU/Price) etc

                    for($i = 0; $i < sizeof($output->result); ++$i)
                    {
                        //converts the description to HTML decodes, strips slashes
                        $output->result[$i]->Description = htmlspecialchars_decode(stripslashes($output->result[$i]->Description));
                        
                        $data = $curl->addProduct($output->result[$i], $sources->system_sources[0], $_SESSION['settings']);
                        if($data != null)
                        {
                            //update table Stock2Shop
                            $curl->insertStock2Shop($connection, $output->result[$i]->SKU, date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']));
                            array_push($pushed->system_products, $data);
                        }
                        else
                        {
                            if(isset($_SESSION['log']))
                            {
                                $connnection->addLogs('Push Product', "Product with SKU " . $output->result[$i]->SKU . " was not processed because of NULL Data", date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true);
                            }
                        }
                    }
                    echo(json_encode($curl->push($pushed, $sources->system_sources[0], $token, $username, $password)));
                }
                else
                {
                    json_encode($curl->getSources($token,$username, $password));
                    exit();
                }
            }
            else
            {
                $variable = new \stdClass();
                $variable->result = true;
                $variable->message = 'Stock2Shop Push - SKU ' . $sku . ' was added to queue';
                echo(json_encode($variable));
                //pauses the execution a small bit to allow the javascript messages to show
                sleep(2);
                exit();
            }
        }
    }
?>