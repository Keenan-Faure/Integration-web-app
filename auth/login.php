<?php 
    session_start();
    include('../Class Templates/createConnection.php');
    use Connection\Connection as connect;

    $_config = include('../config/config.php');
    $_settings = include('../config/s2s_settings.php');
    $_woocommerce = include('../config/woo_settings.php');
    
    $_SESSION['log'] = array();
    $conn = new connect(); 

    //saves the settings inside the session
    //S2S && Woocommerce
    $_SESSION['settings'] = $conn->setSettings($_settings);
    $_SESSION['woo_settings'] = $conn->setSettings($_woocommerce);

    $query = 'SHOW TABLES';
    $result = $conn->preQuery($_config, $query, 'array');
    if(isset($result->connection))
    {
        if($result->connection == false)
        {
            $conn->createHtmlMessages('', $result->message, "Please ensure:<br> - MySQL is installed <br> - MySQL is running <br> - Credentials are configured in the config file", '../auth/login', 'warn');
            exit();
        }
    }
    for($i = 0; $i < sizeof($result); ++$i)
    {
        $result[$i] = strtolower($result[$i]);
    }
    if(!in_array("users", $result))
    {
        //create the table
        $query = 'CREATE TABLE Users(
            Active varchar(5),
            UserID int AUTO_INCREMENT primary key NOT NULL,
            Username varchar(255),
            Password varchar(255),
            Email varchar(255),
            Notes TEXT)';

        $result2 = $conn->preQuery($_config, $query, 'object');   
        if(isset($result2->result) == true)
        {
            if($result2->result == true)
            {
                $_SESSION['setTables'] = true;
            }
        }

        //create admin user
        $query = 'SELECT COUNT(*) as total FROM Users WHERE Username = "' . $_config['dbName'] . '" & Password = "' . $_config['dbPass'] . '"';
        $result3 = $conn->preQuery($_config, $query, 'object');
        if($result3->result[0]->total == 0)
        {
            //create admin user
            $query = 'INSERT INTO Users(Username, Password) VALUES("' . $_config['dbUser'] . '", "'. $_config['dbPass'] .'")';
            $result3 = $conn->preQuery($_config, $query, 'object');
        }
    }
    if(!in_array("logs", $result))
    {
        //create the table
        $query = 'CREATE TABLE Logs(
            Head varchar(255),
            Body varchar(255),
            T_ime varchar(255),
            T_ype varchar(255))';
        $conn->preQuery($_config, $query, 'object');
    }
    if(!in_array("woocommerce", $result))
    {
        //create the table
        $query = 'CREATE TABLE Woocommerce(
            SKU varchar(255),
            ID varchar(255),
            P_ID varchar(255),
            pushDate varchar(255))';
        $conn->preQuery($_config, $query, 'object');
    }
    if(!in_array("stock2shop", $result))
    {
        //create the table
        $query = 'CREATE TABLE Stock2Shop(
            SKU varchar(255),
            Pushed varchar(255),
            pushDate varchar(255))';
        $conn->preQuery($_config, $query, 'object');
    }
    if(!in_array("orders", $result))
    {
        //create the table
        $query = 'CREATE TABLE Orders(
            ID varchar(255),
            orderStatus varchar(255),
            currency varchar(255),
            total varchar(255),
            subTotal varchar(255),
            totalTax varchar(255), 
            totalShipping varchar(255),
            shippingTax varchar(255),
            discount varchar(255),
            paymentDetails varchar(1020),  #object
            billingAddress varchar(1020),  #object
            shippingAddress varchar(1020), #object
            note varchar(1020),
            lineItems varchar(2040),       #array[object(s)] - uses sterilze for these
            shippingLines varchar(1020),   #object
            taxLines varchar(1020),        #object
            customer varchar(2040),        #object
            auditDate varchar(255))';
        $conn->preQuery($_config, $query, 'object');
    }

?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="../Images/logo.png"/>
        <link rel='stylesheet' href='../Styles/login.css'>
    </head>
    <body>
        <div class = 'background'>
        <div class = 'background-cover'></div>
            <h1 id='header1'>Login to MySql Server</h1>
            <div class='line' id='line'></div>
            <div class="modalContainer">
                <form method='post' action='../bin/controllers/connect.php'>
                    <input type='text' autocomplete="off" name='uname' placeholder='Enter Username' id='f1' required>
                    <br><br>
                    <input type='password' autocomplete="off" name='psw' placeholder='Enter Password' id='f2'>
                    <br><br>
                    <input type='text' name='host' placeholder='Localhost' id='f3' readonly>
                    <br><br>
                    <input class = 'button' type='submit' id='f4'>
                </form>
                </div>
            </div>
        </div>
        </div>
    </body>
    <script src='../Scripts/script3.js'></script>
</html>