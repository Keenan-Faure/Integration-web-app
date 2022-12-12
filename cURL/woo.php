<?php

    session_start();
    include("../Class Templates/createConnection.php");
    $_woocommerce = include("../config/woo_settings.php");

    use Connection\Connection as connect;
    $conn = new connect();
    if(!isset($_SESSION['clientConn']->token))
    {
        $conn->createHtmlMessages('', 'Error connecting to user session', 'No connection found in current session, please re-connect', '../auth/login', 'info');
        exit();
    }
?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="../Images/logo.png"/>
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
                        <div class="dropDown">
                        <button class="dropDownBtn">Orders</button>
                        <div class="dropDownContent">
                            <a href="../orders/orderList.php?page=1">View all Orders</a>
                        </div>
                    </div>
                    </div>
                    <div class='buttonContainer'>
                        <div class="dropDown">
                        <button class="dropDownBtn">Products</button>
                            <div class="dropDownContent">
                                <a href="../products/addItem.html">Add Product</a>
                                <a href="../products/productList.php?page=1">View all products</a>
                                <a href="../products/importUtils/import.html">Import Products</a>
                                <a href="../products/importUtils/productExport.php">Export Products</a>
                            </div>
                        </div>
    
                        <div class="dropDown">
                        <button class="dropDownBtn">Customers</button>
                            <div class="dropDownContent">
                                <a href="../customers/customers/addCustomer.html">Add Customer</a>
                                <a href="../customers/editCustomer.php">View Customers</a>
                            </div>
                        </div>
                    </div>
                    <a id='push-woo' href='woo.html' target="_blank" class='buttonPush-Woo'>Push Products</a>
                    </div>
                </div>
        <div class='modalContainer-Woo'>
            <form id='form' action="execute.php" method='post' target='_blank'>
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
                <div id='post'>
                    <div class="containerText">Post Data</div>
                    <hr class='line'>
                    <textarea id='pst' type='text' class = 'postData' name='pst' title='Post Data'><?php 
                        
                    ?></textarea>
                </div>
                <div id='rmv1'>
                <div class="containerText">Consumer Key</div>
                <hr class='line'>
                <textarea id='ck' type='text' class = 'appTitle-textarea-Woo' name='ck' title='Consumer Key' required><?php 
                        if(isset($_SESSION['woo_settings']))
                        {
                            if(isset($_SESSION['woo_settings']->Woocommerce_Store))
                            {
                                echo($_SESSION['woo_settings']->Woocommerce_Store->consumer_key);
                            }
                        }
                    ?></textarea>
                </div>
                <br>
                <div id='rmv2'>
                <div class="containerText">Consumer Secret</div>
                <hr class='line'>
                <textarea id='cs' type='password' class = 'appTitle-textarea-Woo' autocomplete="off" name='cs' title='Consumer Secret' required><?php 
                        if(isset($_SESSION['woo_settings']))
                        {
                            if(isset($_SESSION['woo_settings']->Woocommerce_Store))
                            {
                                echo($_SESSION['woo_settings']->Woocommerce_Store->consumer_secret);
                            }
                        }
                    ?></textarea>
                </div>
                <br>
                <div class="containerText">URL</div>
                <hr class='line'>
                <textarea type='password' id='url' class='appTitle-textarea-Woo' autocomplete="off" name='url' title='URL' required><?php 
                        
                    ?></textarea>
                <br><br>
                <div class="containerText">Endpoint</div>
                <hr class='line'>
                <select class="appTitle-Woo" name="endpoint" onchange="changeUrl(this, document.getElementById('store_name').value)">
                    <option value="">Select Endpoint</option>
                    <optgroup label="General">
                        <option value="woo_Auth">Check API</option>
                    </optgroup>
                    <optgroup label="Customer">
                        <option value="woo_getCustomer">GET customer</option>
                        <option value="woo_getCustomer_l">GET customer list</option>
                        <option value="woo_deleteCustomer">DELETE customer</option>
                        <option value="woo_updateCustomer">UPDATE customer</option>
                        <option value="woo_postCustomer">POST customer</option>
                    </optgroup>
                    <optgroup label="Orders">
                        <option value="woo_getOrder">GET order</option>
                        <option value="woo_getOrder_l">GET order list</option>
                        <option value="woo_deleteOrder">DELETE order</option>
                        <option value="woo_updateOrder">UPDATE order</option>
                        <option value="woo_postOrder">POST order</option>
                    </optgroup>
                    <!--
                    <optgroup label="Order Notes">
                        <option value="woo_getOrderNote">GET order note</option>
                        <option value="woo_getOrderNote_l">GET order note list</option>
                        <option value="woo_deleteOrderNote">DELETE order note</option>
                        <option value="woo_postOrderNote">POST order note</option>
                    </optgroup>
                    -->
                    <optgroup label="Products">
                        <option value="woo_getProduct">GET product</option>
                        <option value="woo_getProductBySKU">GET product by SKU</option>
                        <option value="woo_getProduct_l">GET product list</option>
                        <option value="woo_deleteProduct">DELETE product</option>
                        <option value="woo_updateProduct">Update product</option>
                        <option value="woo_createProduct">POST product</option>
                    </optgroup>
                    <!--
                    <optgroup label="Product variations">
                        <option value="woo_getProductVariation">GET product variation</option>
                        <option value="woo_getProductVariation_l">GET product variation list</option>
                        <option value="woo_deleteProductVariation">DELETE product variation</option>
                        <option value="woo_updateProductVariation">Update product variation</option>
                        <option value="woo_postProductVariation">POST product variation</option>
                    </optgroup>
                    -->
                    <optgroup label="Other">
                        <option value="woo_getProductAttribute_l">GET attribute list</option>
                        <option value="woo_getProductCategories_l">GET category list</option>
                        <option value="woo_getProductShipClas_l">GET shipping classes</option>
                        <option value="woo_getWebhook_l">GET webhooks</option>
                        <!-- <option value="woo_getSystemStatus">GET system status</option> -->
                    </optgroup>
                </select>
                <input class='button' type='submit'>
            </form>
        </div>
    </div>
    <script src='../Scripts/url_woo.js'></script>
</html>