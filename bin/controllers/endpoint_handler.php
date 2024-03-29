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
    include("../../Class Templates/createConnection.php");
    include("../../Class Templates/utility.php");
    $_config = include('../../config/config.php');
    use Connection\Connection as connect;
    use utils\Utility as util;

    if(isset($_SESSION['connection']))
    {
        if($_SESSION['connection']->active === true)
        {
            if(($_POST == null))
            {
                echo('<div class="errors"><p>Error occurred: No endpoint selected, please return</p></div>');
                header('Refresh:2, url=dashboard.php');
                exit();
            }
            if(isset($_POST['addCustomer']))
            {
                header("Refresh:0, url=../../customers/addCustomer.html");
                unset($_POST['addCustomer']);
                exit();
            }
            if(isset($_POST['addProduct']))
            {
                header("Refresh:0, url=../../products/addItem.html");
                unset($_POST['addProduct']);
                exit();
            }
            if(isset($_POST['productList']))
            {
                header('Refresh:0, url=../../products/productList.php?page=1');
                unset($_POST['productList']);
                exit();
            }
            if(isset($_POST['viewOrders']))
            {
                header('Refresh:0, url=../../orders/orderList.php?page=1');
                unset($_POST['viewOrders']);
                exit();
            }
            if(isset($_POST['editCustomer']))
            {
                header('Refresh:0, url=../../customers/customerList.php?page=1');
                unset($_POST['editCustomer']);
                exit();
            }
            if(isset($_POST['selfquery']))
            {
                $connection = new connect();
                $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                
                //creates query and trims
                $query = trim($_POST['selfquery']);
                
                $output = $connection->converterObject($rawConnection, $query, 'selfquery');
                mysqli_close($rawConnection);
                unset($_POST['selfquery']);
                if(isset($output->result[0]->Password))
                {
                    $output->result[0]->Password = "******";
                } 
                echo(json_encode($output));                
                exit;
            }
            if(isset($_POST['getOrderByID']))
            {
                $connection = new connect();
                $util = new util();
                $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                //creates query
                
                $query = "SELECT * FROM Orders WHERE ID='" . $_POST['getOrderByID'] . "'";

                $output2 = $connection->converterObject($rawConnection, $query);
                mysqli_close($rawConnection);

                $result = $util->unserializeOrder($output2->result);

                echo(json_encode($result));
                unset($_POST['getOrderByID']);
                exit();
            }
            if(isset($_POST['countOrders']))
            {
                $connection = new connect();
                $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                //creates query
                
                $query = "SELECT COUNT(*) as 'Count' FROM Orders";

                $output = $connection->converterObject($rawConnection, $query);
                mysqli_close($rawConnection);
                echo(json_encode($output));
                unset($_POST['countOrders']);
                exit();
            }
            if(isset($_POST['viewOrders']))
            {

            }
            else
            {
                if(isset($_POST['getProductBySKU']) && $_POST['getProductBySKU'])
                {
                    $connection = new connect();
                    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                    //creates query
                    
                    $query = "SELECT * FROM Inventory WHERE SKU='" . $_POST['getProductBySKU'] . "'";

                    $output = $connection->converterObject($rawConnection, $query);
                    mysqli_close($rawConnection);
                    echo(json_encode($output));
                    unset($_POST['getProductBySKU']);
                }
                else if(isset($_POST['getProductsBatch']))
                {
                    $connection = new connect();

                    //creates connection and query
                    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                    $query = "SELECT * FROM Inventory LIMIT 15";

                    $output = $connection->converterObject($rawConnection, $query);
                    mysqli_close($rawConnection);
                    echo(json_encode($output));
                    unset($_POST['getProductsBatch']);
                }
                else if(isset($_POST['countProduct']))
                {
                    $connection = new connect();
                    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                    //creates query
                    
                    $query = "SELECT COUNT(*) as 'Count' FROM Inventory";

                    $output = $connection->converterObject($rawConnection, $query);
                    mysqli_close($rawConnection);
                    echo(json_encode($output));
                    unset($_POST['countProduct']);
                }
                else if(isset($_POST['viewProductSql']))
                {
                    $variable = new \stdClass();
                    $variable->getProductsBySKU = new \stdClass();
                    $variable->getProductsBySKU->query = "SELECT * FROM Inventory WHERE SKU= '{{SKU}}'";
                    $variable->getProductsBySKU->result = 'returns all products whose SKU matches {{SKU}}';
                    $variable->getProductsBySKU->accepts_data = true;

                    $variable->getProducts = new \stdClass();
                    $variable->getProducts->query = $query = "SELECT * FROM Inventory LIMIT 15";
                    $variable->getProducts->result = 'returns the first 10 products from the table';
                    $variable->getProducts->accepts_data = true;

                    $variable->countProducts = new \stdClass();
                    $variable->countProducts->query = "SELECT COUNT(*) as 'Count' FROM Inventory";
                    $variable->countProducts->result = 'returns the amount of products in the Inventory table';
                    $variable->countProducts->accepts_data = false;
                    $data = new \stdClass();
                    $data->return = $variable;
                    echo(json_encode($data));
                    unset($_POST['viewProductSql']);
                }
                else if(isset($_POST['getCustomerByID']))
                {
                    $connection = new connect();
                    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                    //creates query
                    
                    $query = "SELECT * FROM Client WHERE ID='" . $_POST['getCustomerByID'] . "'";

                    $output = $connection->converterObject($rawConnection, $query);
                    mysqli_close($rawConnection);
                    echo(json_encode($output));
                    unset($_POST['getCustomerByID']);
                }
                else if(isset($_POST['countCustomer']))
                {
                    $connection = new connect();
                    $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                    //creates query
                    
                    $query = "SELECT COUNT(*) as 'Count' FROM Client";

                    $output = $connection->converterObject($rawConnection, $query);
                    mysqli_close($rawConnection);
                    echo(json_encode($output));
                    unset($_POST['countCustomer']);
                }
                else if(isset($_POST['viewCustomerSql']))
                {
                    $variable = new \stdClass();
                    $variable->getCustomerByName = new \stdClass();
                    $variable->getCustomerByName->query = "SELECT * FROM Client WHERE ID= '{{Name}}'";
                    $variable->getCustomerByName->result = 'returns all products whose Name matches {{Name}}';
                    $variable->getCustomerByName->accepts_data = true;

                    $variable->countCustomer = new \stdClass();
                    $variable->countCustomer->query = "SELECT COUNT(*) as 'Count' FROM Client";
                    $variable->countCustomer->result = 'returns the amount of customers in the Client table';
                    $variable->countCustomer->accepts_data = false;
                    $data = new \stdClass();
                    $data->return = $variable;
                    echo(json_encode($data));
                    unset($_POST['viewCustomerSql']);
                }
                else
                {
                    $conn = new connect();
                    $variable = new \stdClass();
                    $variable->error = 'No valid endpoint found';
                    $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
                    $variable->message = 'Please return and reselect';
                    $variable = json_encode($variable, JSON_PRETTY_PRINT);
                    $conn->addLogs('No valid endpoint found', 'Undefined URL', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'warn', true, $_config);

                    $conn->createJsonMessages("Not a valid URL", "$variable", "../../endpoints", "warn", "php");
                }
            }
        }
    }
    else
    {
        $conn = new connect();
        $variable = new \stdClass();
        $variable->active = false;
        $variable->message = 'No connection found in current session, please re-connect';
        $variable->failedPage = 'endpoint_handler.php';
        $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        $variable = json_encode($variable, JSON_PRETTY_PRINT);
        if(isset($_SESSION['log']))
        {
            $conn->addLogs('No Session', 'Attempted to connect but no session was found', date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']), 'info', false, $_config);
        }
        $conn->createJsonMessages("No Session found", "$variable", "../../endpoints", "warn", "php");
    }

?>
