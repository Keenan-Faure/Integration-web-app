<?php

    session_start();
    include("../createConnection.php");
    $_woocommerce = include("../config/woo_settings.php");

    use Connection\Connection as connect;
    $conn = new connect();

    if(!isset($_SESSION['connection']->token))
    {
        $conn->createHtmlMessages('Error connecting to user session', 'No connection found in current session, please re-connect', 'login', 'info');
        exit();
    }
?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
        <link rel='stylesheet' href='../Styles/addItem.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../Scripts/app.js"></script>
    </head>
    <body>
    <div class='backgroundApp-Woo'>
    <div class="navBar">
                <div class="overlay">
                    <div class='imageNav'></div>
                    <h1>Woo-App</h1>
                    <div class='buttonContainer2'>
                        <div class="dropDown">
                        <button class="dropDownBtn">Home</button>
                            <div class="dropDownContent">
                                <a href="../endpoints.php">Dashboard</a>
                            </div>
                        </div>
                    </div>
                    <div class='buttonContainer'>
                        <div class="dropDown">
                        <button class="dropDownBtn">Products</button>
                            <div class="dropDownContent">
                                <a href="../addItem.html">Add Product</a>
                                <a href="../productList.php?page=1">View all products</a>
                                <a href="../importUtils/import.html">Import Products</a>
                                <a href="../importUtils/productExport.php">Export Products</a>
                            </div>
                        </div>
    
                        <div class="dropDown">
                        <button class="dropDownBtn">Customers</button>
                            <div class="dropDownContent">
                                <a href="../addCustomer.html">Add Customer</a>
                                <a href="../editCustomer.php">View Customers</a>
                            </div>
                        </div>
                    </div>
                    <a href="../Import utilities/import.html" class="buttonOption"></a>
    
                    </div>
                </div>
        <div class='modalContainer-Woo'>
            <form action="execute.php" method='post' target='_blank'>
                <div class="containerText">Store Name</div>
                <hr class='line'>
                <textarea id='store_name' type='text' class = 'appTitle-textarea-Woo' name='store_name' title='Woocommerce Store Name' required><?php 
                        if(isset($_SESSION['woo_settings']))
                        {
                            if(isset($_SESSION['woo_settings']->Woocommerce_Store))
                            {
                                echo($_SESSION['woo_settings']->Woocommerce_Store->store_name);
                            }
                        }
                    ?></textarea>
                <br><br>
                <div class="containerText">Consumer Key</div>
                <hr class='line'>
                <textarea type='text' class = 'appTitle-textarea-Woo' name='ck' title='Consumer Key' required><?php 
                        if(isset($_SESSION['woo_settings']))
                        {
                            if(isset($_SESSION['woo_settings']->Woocommerce_Store))
                            {
                                echo($_SESSION['woo_settings']->Woocommerce_Store->consumer_key);
                            }
                        }
                    ?></textarea>
                <br><br>
                <div class="containerText">Consumer Secret</div>
                <hr class='line'>
                <textarea type='password' class = 'appTitle-textarea-Woo' autocomplete="off" name='cs' title='Consumer Secret' required><?php 
                        if(isset($_SESSION['woo_settings']))
                        {
                            if(isset($_SESSION['woo_settings']->Woocommerce_Store))
                            {
                                echo($_SESSION['woo_settings']->Woocommerce_Store->consumer_secret);
                            }
                        }
                    ?></textarea>
                <br><br>
                <div class="containerText">URL</div>
                <hr class='line'>
                <textarea type='password' id='url' class='appTitle-textarea-Woo' autocomplete="off" name='cs' title='Consumer Secret' required><?php 
                        
                    ?></textarea>
                <br><br>
                <div class="containerText">Endpoint</div>
                <hr class='line'>
                <select class="appTitle-Woo" name="endpoint" onchange="changeUrl(this, document.getElementById('store_name').value)">
                    <option value="">Select Endpoint</option>
                    <optgroup label="General">
                        <option value="wooAuthenticate">Check API</option>
                    </optgroup>
                    <optgroup label="Customer">
                        <option value="getCustomer">GET customer</option>
                    </optgroup>
                </select>
                <input class='button' type='submit'>
            </form>
        </div>
    </div>
    <script src='../Scripts/url_woo.js'></script>
</html>