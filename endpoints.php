<html>
    <head>
        <link rel='stylesheet' href='Styles/endpoints.css'>
    </head>
    <body>
            <?php 
                session_start();
            ?>
            <div class='background'>
            </div>
            <div class='selfBackground top'>
                <div class='buttonContainer'></div>
                <button class='closeButton'>&times;</button>
                
                <h1>Custom Query</h1>
                <div class='line-2'></div>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                        <br><br><br>
                        <textarea class='textarea' name='selfquery' placeholder='Enter your query here'></textarea>
                        <button type = 'submit' class='enter'>Submit</button>
                </form>
            </div>
            <h1>Available Endpoints</h1>
            <div class='line'></div>
            <img src='./Images/custom.png' title = "Query custom Sql" class='custom'>
            <div class='container' id='container-1'>
                <h2 class='h2-hidden'>General</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <br><br><br>
                    <button name='checkConnection' class='button' id='b1'><p class='buttonText'>Check Connection</p></button>
                    <br><br>
                    <button name='viewLog'class='button' id='b2'><p class='buttonText'>View Log</p></button>
                    <br><br>
                    <button name='visitS2S' class='button' id='b3'><p class='buttonText'>Visit Stock2Shop</p></button>
                    <br><br>
                    <button name='checkTables' class='button' id='b4'><p class='buttonText'>Check Tables in Database</p></button>
                </form>
            </div>

            <div class='container' id='container-2'>
                <h2 class='h2-hidden'>Products</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <br><br><br>
                    <input type='text' class='input' name='getProductBySKU' placeholder='Get Product by SKU' autocomplete="off" id='b5'></input>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <button type='text' name='getProductsBatch' class='button' id='b6'><p class='buttonText'>Get Products (10)</p></button>
                </form>
                
                <form  method='post' target='_blank' action='endpoint_handler.php'>
                    <button class='button' name='countProduct' id='b7'><p class='buttonText'>Count Products</p></button>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <button class='button' name='viewProductSql' id='b8'><p class='buttonText'>View Product Sql queries</p></button>
                </form>
                <form method='post' action='endpoint_handler.php'>
                    <button class='button' name='addProduct' id='b9'><p class='buttonText'>Add Product to Database</p></button>               
                </form>
                <form method='post' action='endpoint_handler.php'>
                    <button class='button' name='editProduct' id='b10'><p class='buttonText'>Edit Products</p></button>               
                </form>
            </div>

            <div class='container' id='container-3'>
                <h2 class='h2-hidden'>Customers</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <br><br><br>
                    <input type='text' name='getCustomerByID' class='input' placeholder='Get Customer by ID' autocomplete="off" id='b11'></input>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <button class='button' name='countCustomer' id='b12'><p class='buttonText'>Count Customers</p></button>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <button class='button' name='viewCustomerSql' id='b13'><p class='buttonText'>View Customer Sql queries</p></button>
                </form>
                <form method='post' action='endpoint_handler.php'>
                    <button class='button' name='addCustomer' id='b14'><p class='buttonText'>Add Customer to Database</p></button> 
                </form>
                <form method='post' action='endpoint_handler.php'>
                    <button class='button' name='editCustomer' id='b15'><p class='buttonText'>Edit Customer</p></button> 
                </form>
            </div>
                
            <a href='cURL/example.php' style='right: 0;bottom: 0;position: absolute;'>Push Products</a>     
    </body>
        <script src='Scripts/scripts2.js'></script>
</html>
<?php

echo('<div class="errorTable">');
if(!isset($_SESSION['connection']))
{
    echo('<div class="errors"><p class="align">No Connection found in current session</p></div>');
}

include("createConnection.php");
use Connection\Connection as connect;
if(isset($_SESSION['rawconnection']) && isset($_SESSION['connection']))
{
    $rawConnection = $_SESSION['rawconnection'];
    if(isset($_SESSION['credentials']) && $_SESSION['credentials']->active == true)
    {
        $counter = false;
        $cust = false;
        $knownDbs = array('information_schema', 'mysql', 'performance_schema', 'phpmyadmin', 'test');
        $connection = new connect();

        $output = $_SESSION['databases'];
        for($p = 0; $p < sizeof($output); ++$p)
        {
            if(isset($_SESSION['connection']))
            {
                $connection2 = new connect();
                $rawConnection = $connection2->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query2 = 'show tables';
                $output2 = $connection2->converterArray($rawConnection, $query2, "Tables_in_" . $_SESSION['connection']->credentials->dbname);
                if(!in_array("Inventory", $output2))
                {
                    $counter = true;
                }
                if(!in_array("Client", $output2))
                {
                    $cust = true;
                }
            }
        }
        if($counter)
        {
            echo('<div class="errors"><p class="align">Inventory table created</p></div>');

            //creates query
            $query3 = " CREATE TABLE Inventory (
                    Token int AUTO_INCREMENT primary key NOT NULL,
                    Type varchar(7),
                    Active varchar(6),
                    SKU varchar(255),
                    Title varchar(255),
                    Description varchar(510),
                    Group_Code varchar(255),
                    Category varchar(255),
                    Product_Type varchar(255),
                    Brand varchar(255),
                    Variant_Code varchar(255),
                    Barcode int,
                    Weight int,
                    CostPrice int,
                    SellingPrice int, 
                    CapeTown_Warehouse int,
                    Option_1_Name varchar(255),
                    Option_1_Value varchar(255),
                    Option_2_Name varchar(255),
                    Option_2_Value varchar(255),
                    Meta_1 varchar(255),
                    Meta_2 varchar(255),
                    Meta_3 varchar(255)
                );
            ";
            
            $output = $connection2->converterObject($rawConnection, $query3);
            $counter = false;
        }
        if($cust)
        {
            echo('<div class="errors"><p class="align">Client table created</p></div>');
            $query4 = " CREATE TABLE Client(

                Token int AUTO_INCREMENT primary key NOT NULL,
                Active varchar(6),
                ID varchar(255),
                Name varchar(255),
                Surname varchar(255),
                Email varchar(255),
                Address_1 varchar(255),
                Address_2 varchar(255),
                Address_3 varchar(255),
                Address_4 varchar(255)
            );
            ";
        
        $output = $connection2->converterObject($rawConnection, $query4);
        $cust = false;
        }
        
    }
    echo('</div>');
    }
?>


