<?php 
    session_start();
    include("createConnection.php");
    use Connection\Connection as connect;
    if(!(isset($_SESSION['connection']) && isset($_SESSION['clientConn'])))
    {
        $conn = new connect();
        $conn->createHtmlMessages('No Login details found in current session', 'Please relog', 'login', false);
        exit();
    }
?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
        <link rel='stylesheet' href='Styles/endpoints.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src='Scripts/createElements.js'></script>
    </head>
    <body>
        <div class='background'>
        </div>
        <div class="navBar">
            <div class="overlay">
                <div class='imageNav'></div>
                <h1 class='navBarHeader'>Dashboard</h1>
                <div class='buttonContainer2'>
                    <div class="dropDown">
                    <button class="dropDownBtn">Session</button>
                        <div class="dropDownContent">
                            <a href="output.php?q=session">Current session</a>
                            <a href="output.php?q=clearLog">Clear log</a>
                            <a href="output.php?logout=true">Logout</a>
                        </div>
                    </div>

                    <div class="dropDown">
                    <button class="dropDownBtn">View API</button>
                        <div class="dropDownContent">
                            <a href='API/v1.php'>Visit API</a>
                            <a href="API/document.html" target='_blank'>Documentation</a>
                            <a href='API/API-collection.json' download='collection.json'>Postman collection</a>
                        </div>
                    </div>
                </div>
                <div class='buttonContainer3'>
                    <div class="dropDown">
                    <button class="dropDownBtn">Settings</button>
                        <div class="dropDownContent">
                            <a href="endpoints/config/s2s_settings.php">View Settings</a>
                            <a href="endpoints/config/woo_settings.php">Woocommerce Settings</a>

                        </div>
                    </div>
                    <div class="dropDown">
                    <button class="dropDownBtn">Push</button>
                        <div class="dropDownContent">
                            <a href='cURL/app.php'>Stock2Shop</a>
                            <a href='cURL/woo.php'>Woocommerce</a>
                            <?php
                                if($_SESSION['settings']->App_settings->app_enable_self_query == 'true')
                                {
                                    echo("<a class='custom'>Custom Query</a>");
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <a class='logoutButton' href='output.php?logout=true'></a>
            </div>
        </div>
        <div class='selfBackground top'>
            <div class='buttonContainer'></div>
            <button class='closeButton'>&times;</button>
            
            <?php
                if($_SESSION['settings']->App_settings->app_enable_self_query == 'true')
                {
                    echo("<h1>Custom Query</h1>
                    <form method='post' target='_blank' action='endpoint_handler.php'>
                            <br><br><br>
                            <textarea class='textarea' name='selfquery' placeholder='Enter your query here'></textarea>
                            <button type = 'submit' class='enter'>Submit</button>
                    </form>");
                }
            ?>
        </div>
        <div class='container' id='container-1'>
            <h2 class='h2-hidden'>General</h2>
            <div class='line' id='line-1'></div>
            <form method='post' target='_blank' action='endpoint_handler.php'>
                <br><br><br>
                <button name='checkConnection' class='button' id='b1'><p class='buttonText'>Check Connection</p></button>
                <br><br>
                <button name='viewLog'class='button' id='b2'><p class='buttonText'>View Log</p></button>
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
                <button class='button' name='productList' id='b10'><p class='buttonText'>Edit Products</p></button>               
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
        <div class='info-report'>
            <div class='rowHeader'>
                ▶ View logs
            </div>
            <?php
                //query and print data inside logs using javascript
                $conn = new connect();

                $rawConnection = $conn->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $jsonLogs = json_encode($conn->converterObject($rawConnection, 'SELECT * FROM Logs')->result);
                echo("<script>initiatorCreateLogs($jsonLogs);</script>");
                
            ?>
        </div>  
    </body>
    <script src='Scripts/scripts2.js'></script>
</html>
<?php

echo('<div class="errorTable">');
if(!isset($_SESSION['connection']))
{
    echo('<div class="errors"><p class="align">No Connection found in current session</p></div>');
}

if(isset($_SESSION['clientConn']) && isset($_SESSION['connection']))
{
    if(isset($_SESSION['clientConn']->credentials) && $_SESSION['connection']->active == true)
    {
        $counter = false;
        $cust = false;
        $cond = false;

        //saves known databases inside session
        $connection = new connect();
        $knownDbs = array('information_schema', 'mysql', 'performance_schema', 'phpmyadmin', 'test', 'sys');
        $conn = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        $output = $connection->converterArray($conn, 'SHOW DATABASES');
        $output = array_diff($output, $knownDbs);
        $_SESSION['databases'] = $output;

        $output = $_SESSION['databases'];

        for($p = 0; $p < sizeof($output); ++$p)
        {
            if(isset($_SESSION['connection']))
            {
                $connection2 = new connect();
                $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query2 = 'show tables';
                $output2 = $connection2->converterArray($rawConnection, $query2);
                for($i = 0; $i < sizeof($output2); ++$i)
                {
                    $output2[$i] = strtolower($output2[$i]);
                }
                if(!in_array("conditions", $output2))
                {
                    $cond = true;
                }
                if(!in_array("inventory", $output2))
                {
                    $counter = true;
                }
                if(!in_array("client", $output2))
                {
                    $cust = true;
                }
                if(!in_array("conditions", $output2))
                {
                    $cond = true;
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
                    Barcode varchar(10),
                    Weight varchar(10),
                    ComparePrice varchar(10),
                    SellingPrice varchar(10), 
                    CapeTown_Warehouse varchar(10),
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
            $query3 = " CREATE TABLE Client(

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
        
            $output = $connection2->converterObject($rawConnection, $query3);
            $cust = false;
        }
        if($cond)
        {
            echo('<div class="errors"><p class="align">Conditions table created</p></div>');
            $query3 = " CREATE TABLE Conditions (
                Token int AUTO_INCREMENT primary key NOT NULL,
                DataValue varchar(10),
                Statement varchar(2),
                Value varchar(30)
            );
            ";
        
            $output = $connection2->converterObject($rawConnection, $query3);
            $cond = false;
        }
        if($cond)
        {
            echo('<div class="errors"><p class="align">Conditions table created</p></div>');
            $query4 = " CREATE TABLE Conditions(

                Token int AUTO_INCREMENT primary key NOT NULL,
                DataValue varchar(10),
                Conditions varchar(2),
                Value varchar(20)
            );
            ";
        
        $output = $connection2->converterObject($rawConnection, $query4);
        $cond = false;
        }
    }
    echo('</div>');
    }
?>


