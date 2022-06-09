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
    if(isset($_SESSION['connection']))
    {
        if($_SESSION['connection']->active === true)
        {
            if(($_POST == null))
            {
                echo('<div class="errors"><p>Error occurred: No endpoint selected, please return</p></div>');
                header('Refresh:2, url=endpoints.php');
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
                unset($_POST['getProductBySKU']);
            }
            if(isset($_POST['getProductsBatch']))
            {
                echo("getting product batch");
                unset($_POST['getProductsBatch']);
            }
            if(isset($_POST['countProduct']))
            {
                echo("counting products");
                unset($_POST['countProduct']);
            }
            if(isset($_POST['viewProductSql']))
            {
                echo("view product sql");
                unset($_POST['viewProductSql']);
            }
            if(isset($_POST['addProduct']))
            {
                echo("adding product ");
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

<?php 

function select($query, $connection)
{
    print_r($_SESSION['rawconnection']);
}

?>