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
            if(isset($_POST['table']))
            {
                $variable = new \stdClass();
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
                header('Refresh:3, url=endpoints.php');
            }
            if(isset($_POST['selfquery']))
            {
                $connection = new connect();
                $rawConnection = $connection->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $_SESSION['rawconnection'] = $rawConnection;
                //creates query
                $query = trim($_POST['selfquery']);
                
                $output = $connection->converterObject($rawConnection, $query);
                mysqli_close($rawConnection);
                echo(json_encode($output));
                
            }
            if(isset($_POST['checkConnection']))
            {
                echo(json_encode($_SESSION['connection']));
                unset($_POST['checkConnection']);
            }
            if(isset($_POST['viewLog']))
            {
                echo(json_encode($_SESSION['log']));
                unset($_POST['viewLog']);
            }
            if(isset($_POST['visitS2S']))
            {

                header('Refresh:0,url=https://stock2shop.com');
                unset($_POST['visitS2S']);
            }
            if(isset($_POST['getProductBySKU']) && $_POST['getProductBySKU'])
            {
                $connection = new connect();
                $rawConnection = $connection->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $_SESSION['rawconnection'] = $rawConnection;
                //creates query
                
                $query = "SELECT * FROM " . $_SESSION['tablecurrent'] . " WHERE Name='" . $_POST['getProductBySKU'] . "'";

                $output = $connection->converterObject($rawConnection, $query);
                mysqli_close($rawConnection);
                echo(json_encode($output));
                unset($_POST['getProductBySKU']);
            }
            if(isset($_POST['getProductsBatch']))
            {
                $connection = new connect();
                $rawConnection = $connection->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $_SESSION['rawconnection'] = $rawConnection;
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
                $rawConnection = $connection->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $_SESSION['rawconnection'] = $rawConnection;
                //creates query
                
                $query = "SELECT COUNT(*) FROM " . $_SESSION['tablecurrent'];

                $output = $connection->converterObject($rawConnection, $query);
                mysqli_close($rawConnection);
                echo(json_encode($output));
                unset($_POST['countProduct']);
            }
            if(isset($_POST['viewProductSql']))
            {
                $variable = new \stdClass();
                $variable->getProductsBySKU = new \stdClass();
                $variable->getProductsBySKU->query = "SELECT * FROM " . $_SESSION['tablecurrent'] . " WHERE Name= '{{Name}}'";
                $variable->getProductsBySKU->result = 'returns all products whose Name matches {{Name}}';

                $variable->getProducts = new \stdClass();
                $variable->getProducts->query = $query = "SELECT * FROM " . $_SESSION['tablecurrent'] . " LIMIT 15";
                $variable->getProducts->result = 'returns the first 10 products from the table';

                $variable->countProducts = new \stdClass();
                $variable->countProducts->query = "SELECT COUNT(*) FROM " . $_SESSION['tablecurrent'];
                $variable->countProducts->result = 'returns the amount of products in the Test table';

                echo(json_encode($variable));
                unset($_POST['viewProductSql']);
            }
            if(isset($_POST['addProduct']))
            {
                echo("adding product needs redirect");
                unset($_POST['addProduct']);
            }
            if(isset($_POST['getCustomerByName']))
            {
                echo("getCustomerby name");
                unset($_POST['getCustomerByName']);
            }
            if(isset($_POST['countCustomer']))
            {
                echo("count customers");
                unset($_POST['countCustomer']);
            }
            if(isset($_POST['viewCustomerSql']))
            {
                echo("view customer sql");
                unset($_POST['viewCustomerSql']);
            }
            if(isset($_POST['addCustomer']))
            {
                echo("add a customer to the database");
                unset($_POST['addCustomer']);
            }
        }
    }
    else
    {
        $variable = new \stdClass();
        $variable->active = 'false';
        $variable->message = 'No connection found in current session, please re-connect';
        $variable->failedPage = 'AP.php';
        $variable->timestamp = date('m/d/Y H:i:s', $_SERVER['REQUEST_TIME']);
        $variable->redirectTime = '3 seconds';

        echo(json_encode($variable));
        header('Refresh:3, url=login.php');
        array_push($_SESSION['log'], $variable);
    }

?>
