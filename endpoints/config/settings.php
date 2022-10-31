<?php

    session_start();
    include("../../createConnection.php");
    use Connection\Connection as connect;
    if(!isset($_SESSION['clientConn']) && !isset($_SESSION['connection']))
    {
        $conn = new connect();
        $message = 'No Session found for this user';
        $solution = 'Please relog';
        $link = 'login';
        echo("
            <html>
                <head>
                    <link rel='icon' type=image/x-icon' href='Images/logo.png'/>
                    <link rel='stylesheet' href='Styles/login.css'>
                </head>
                <body>
                    <div>
                    </div>
                    <div>
                        <div>
                        </div>
                        <div>
                            <h2>Message</h2>          
                            <p>$message</p>
                            <hr>
                            <p>$solution</p>
                            <div >
                                <a href='../../$link.php'>Redirect</a>
                            </div>
                        </div>
                    </div>
                </body>
            </html>
        ");
        exit();
    }

?>

<html>
    <head>
        <link rel="stylesheet" href="../../Styles/productList.css">
        <link rel="icon" type="image/x-icon" href="../../Images/logo.png"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="navBar">
            <div class="overlay">
                <div class='imageNav'></div>
                <h1>Edit Products</h1>
                <div class='buttonContainer2'>
                    <div class="dropDown">
                    <button class="dropDownBtn">Home</button>
                        <div class="dropDownContent">
                            <a href="endpoints.php">Dashboard</a>
                        </div>
                    </div>
                </div>
                <div class='buttonContainer'>
                <div class="dropDown">
                <button class="dropDownBtn">Products</button>
                    <div class="dropDownContent">
                        <a href="addItem.html">Add Product</a>
                        <a href="productList.php?page=1">View all products</a>
                        <a href="importUtils/import.html">Import Products</a>
                        <a href="importUtils/productExport.php">Export Products</a>
                    </div>
                </div>

                    <div class="dropDown">
                    <button class="dropDownBtn">Customers</button>
                        <div class="dropDownContent">
                            <a href="addCustomer.html">Add Customer</a>
                            <a href="editCustomer.php">View Customers</a>
                        </div>
                    </div>
                </div>
                <a href="importUtils/import.html" class="buttonOption"></a>
                </div>
            </div>
        </div>
    </body>
</html>