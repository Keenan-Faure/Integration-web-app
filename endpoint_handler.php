<style>
    .errors
    {
        text-align: center;
        width: 600px;
        font-size: 20px;
        height: 60px;
        top: 50%;
        left: 50%;
        position: absolute;
        background-color: rgba(216, 216, 216, 0.2);
        color: red;
        transform: translate(-50%, -50%);
    }
    p
    {
        text-align: center;
    }
</style>
<?php
    session_start();
    include("createConnection.php");
    use Connection\Connection as connect;
    if(isset($_SESSION['connection']))
    {
        if($_SESSION['connection']->active === true)
        {
            if(($_POST == null))
            {
                echo('<div class="errors"><p>Error occurred: No endpoint selected, please return</p></div>');
                header('Refresh:2, url=endpoints.php');
            }
            if(isset($_POST['addCustomer']))
            {
                header("Refresh:0, url=addCustomer.html");
                unset($_POST['addCustomer']);
                exit();
            }
            if(isset($_POST['addProduct']))
            {
                header("Refresh:0, url=addItem.html");
                unset($_POST['addProduct']);
                exit();
            }
            if(isset($_POST['table']))
            {
                $connection = new connect();
                $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query = 'show tables';
                $output = $connection->converterArray($rawConnection, $query, "Tables_in_" . $_SESSION['connection']->credentials->dbname);
                if(in_array($_POST['table'], $output))
                {
                    $variable = new \stdClass();
                    $variable->result = true;
                    $variable->prevTable = null;
                    if(isset($_SESSION['tablecurrent']))
                    {
                        $variable->prevTable = $_SESSION['tablecurrent'];
                    }
                    if(isset($_SESSION['tableprev']))
                    {
                        $variable->previousTable = $_SESSION['tableprev'];
                    }
                    $_SESSION['tablecurrent'] = $_POST['table'];
                    $variable->currentTable = $_POST['table'];
                    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);

                    echo(json_encode($variable));
                }
                else
                {
                    $variable = new \stdClass();
                    $variable->result = false;
                    $variable->error = $_POST['table'] . " does not exist in " . $_SESSION['connection']->credentials->dbname;
                    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                    echo(json_encode($variable));
                }
                unset($_POST['table']);
                exit;
            }
            if(isset($_POST['selfquery']))
            {
                $connection = new connect();
                $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                
                //creates query and trims
                $query = trim($_POST['selfquery']);
                
                $output = $connection->converterObject($rawConnection, $query);
                mysqli_close($rawConnection);
                unset($_POST['selfquery']);
                echo(json_encode($output));                
                exit;
            }
            if(isset($_POST['checkTables']))
            {
                $connection = new connect();
                $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                
                //creates query
                $query = "show tables";
                
                $output = $connection->converterObject($rawConnection, $query);
                mysqli_close($rawConnection);
                unset($_POST['selfquery']);
                echo(json_encode($output));                
                exit;
            }
            if(isset($_POST['checkConnection']))
            {
                echo(json_encode($_SESSION['connection']));
                unset($_POST['checkConnection']);
                exit();
            }
            if(isset($_POST['viewLog']))
            {
                echo(json_encode($_SESSION['log']));
                unset($_POST['viewLog']);
                exit();
            }
            if(isset($_POST['visitS2S']))
            {

                header('Refresh:0,url=https://stock2shop.com');
                unset($_POST['visitS2S']);
                exit();
            }
            else
            {
                if(isset($_SESSION['tablecurrent']))
                {
                    if(isset($_POST['getProductBySKU']) && $_POST['getProductBySKU'])
                    {
                        $connection = new connect();
                        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                        //creates query
                        
                        $query = "SELECT * FROM " . $_SESSION['tablecurrent'] . " WHERE SKU='" . $_POST['getProductBySKU'] . "'";

                        $output = $connection->converterObject($rawConnection, $query);
                        mysqli_close($rawConnection);
                        echo(json_encode($output));
                        unset($_POST['getProductBySKU']);
                    }
                    if(isset($_POST['getProductsBatch']))
                    {
                        $connection = new connect();
                        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                        //creates query
                        
                        $query = "SELECT * FROM " . $_SESSION['tablecurrent'] . " LIMIT 15";

                        $output = $connection->converterObject($rawConnection, $query);
                        mysqli_close($rawConnection);
                        echo(json_encode($output));
                        unset($_POST['getProductsBatch']);
                    }
                    if(isset($_POST['countProduct']))
                    {
                        $connection = new connect();
                        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                        //creates query
                        
                        $query = "SELECT COUNT(*) as 'Count' FROM " . $_SESSION['tablecurrent'];

                        $output = $connection->converterObject($rawConnection, $query);
                        mysqli_close($rawConnection);
                        echo(json_encode($output));
                        unset($_POST['countProduct']);
                    }
                    if(isset($_POST['viewProductSql']))
                    {
                        $variable = new \stdClass();
                        $variable->getProductsBySKU = new \stdClass();
                        $variable->getProductsBySKU->query = "SELECT * FROM " . $_SESSION['tablecurrent'] . " WHERE SKU= '{{SKU}}'";
                        $variable->getProductsBySKU->result = 'returns all products whose SKU matches {{SKU}}';
                        $variable->getProductsBySKU->accepts_data = true;

                        $variable->getProducts = new \stdClass();
                        $variable->getProducts->query = $query = "SELECT * FROM " . $_SESSION['tablecurrent'] . " LIMIT 15";
                        $variable->getProducts->result = 'returns the first 10 products from the table';
                        $variable->getProducts->accepts_data = true;

                        $variable->countProducts = new \stdClass();
                        $variable->countProducts->query = "SELECT COUNT(*) as 'Count' FROM " . $_SESSION['tablecurrent'];
                        $variable->countProducts->result = 'returns the amount of products in the ' . $_SESSION['tablecurrent'] . ' table';
                        $variable->countProducts->accepts_data = false;

                        echo(json_encode($variable));
                        unset($_POST['viewProductSql']);
                    }
                    if(isset($_POST['getCustomerByID']))
                    {
                        $connection = new connect();
                        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                        //creates query
                        
                        $query = "SELECT * FROM " . $_SESSION['tablecurrent'] . " WHERE Name='" . $_POST['getCustomerByID'] . "'";

                        $output = $connection->converterObject($rawConnection, $query);
                        mysqli_close($rawConnection);
                        echo(json_encode($output));
                        unset($_POST['getCustomerByID']);
                    }
                    if(isset($_POST['countCustomer']))
                    {
                        $connection = new connect();
                        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                        //creates query
                        
                        $query = "SELECT COUNT(*) as 'Count' FROM " . $_SESSION['tablecurrent'];

                        $output = $connection->converterObject($rawConnection, $query);
                        mysqli_close($rawConnection);
                        echo(json_encode($output));
                        unset($_POST['countCustomer']);
                    }
                    if(isset($_POST['viewCustomerSql']))
                    {
                        $variable = new \stdClass();
                        $variable->getCustomerByName = new \stdClass();
                        $variable->getCustomerByName->query = "SELECT * FROM " . $_SESSION['tablecurrent'] . " WHERE ID= '{{Name}}'";
                        $variable->getCustomerByName->result = 'returns all products whose Name matches {{Name}}';
                        $variable->getCustomerByName->accepts_data = true;

                        $variable->countCustomer = new \stdClass();
                        $variable->countCustomer->query = "SELECT COUNT(*) as 'Count' FROM " . $_SESSION['tablecurrent'];
                        $variable->countCustomer->result = 'returns the amount of customers in the ' . $_SESSION['tablecurrent'] . ' table';
                        $variable->countCustomer->accepts_data = false;
                        echo(json_encode($variable));
                        unset($_POST['viewCustomerSql']);
                    }
                }
                else
                {
                    $variable = new \stdClass();
                    $variable->error = 'No table selected';
                    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                    $variable->message = 'Warning: Undefined array key "tablecurrent"';
                    array_push($_SESSION['log'], $variable);
        
                    echo(json_encode($variable));
                }
            }
        }
    }
    else
    {
        $variable = new \stdClass();
        $variable->active = false;
        $variable->message = 'No connection found in current session, please re-connect';
        $variable->failedPage = 'endpoint_handler.php';
        $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);

        echo(json_encode($variable));
        array_push($_SESSION['log'], $variable);
    }

?>
