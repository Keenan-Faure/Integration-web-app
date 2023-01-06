<?php

    session_start();
    include("../Class Templates/createConnection.php");
    use Connection\Connection as connect;

    $connect = new connect();
    $credentials = $_SESSION['connection']->credentials;
    $connection = $connect->createConnection($credentials->username, $credentials->password, $credentials->host, $credentials->dbname)->rawValue;
    $query = 'SELECT * FROM Conditions';
    $output = $connect->converterObject($connection, $query);
    //displays the conditions found in Conditions
?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="../Images/logo.png"/>
        <link rel='stylesheet' href='../Styles/addItem.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../Scripts/fetch.js"></script>
        <script src="../Scripts/fetchUtils.js"></script>
        <script src="../Scripts/app.js"></script>
        <script src="../Scripts/createElements.js"></script>
    </head>
    <body>
    <div class='backgroundApp'>
    <div class="errorTable">
        <div class="errors"><p class="align">Hover for more information</p></div>
        <br>
        <div class="errors" id="push"><p class="align">Configure Conditions for push</p></div>
    </div>
    <div class='conditionTable'>
        <h1 class='header'>Conditions</h1>
        <?php
            for($i = 0; $i < sizeof($output->result); ++$i)
            {
                $iteration = $output->result[$i];
                echo("
                <div class='condition'>
                    <button class='condition-cls-btn'>&times;</button>
                    <p class='align'>$iteration->DataValue $iteration->Statement $iteration->Value</p>
                </div>
                ");
            }
        ?>
    </div>
    <div class="navBar">
                <div class="overlay">
                    <div class='imageNav'></div>
                    <h1>S2S-App</h1>
                    <div class='buttonContainer2'>
                        <div class="dropDown">
                        <button class="dropDownBtn">Home</button>
                            <div class="dropDownContent">
                                <a href="../dashboard.php">Dashboard</a>
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
                                <a href="../customers/addCustomer.html">Add Customer</a>
                                <a href="../customers/editCustomer.php">View Customers</a>
                            </div>
                        </div>
                    </div>
                    <a id='push-s2s' href='s2s.html' target="_blank" class='buttonPush-S2S'>Push Products</a>            
                    </div>
                </div>
        <div class='modalContainer'>
            <form action="execute.php" method='post' target='_blank'>
                <div class="containerText">Username</div>
                <div class="line"></div>
                <textarea type='text' class = 'appTitle-textarea' name='username' title='Stock2Shop valid username' required><?php 
                        if(isset($_SESSION['settings']))
                        {
                            if(isset($_SESSION['settings']->Stock2Shop_Credentials))
                            {
                                echo($_SESSION['settings']->Stock2Shop_Credentials->s2s_user);
                            }
                        }
                    ?></textarea>
                <div class="containerText">Password</div>
                <div class="line"></div>
                <textarea type='password' class = 'appTitle-textarea' autocomplete="off" name='password' title='Stock2Shop user password' required><?php 
                        if(isset($_SESSION['settings']))
                        {
                            if(isset($_SESSION['settings']->Stock2Shop_Credentials))
                            {
                                echo($_SESSION['settings']->Stock2Shop_Credentials->s2s_password);
                            }
                        }
                    ?></textarea>
                <br><br><br>
                <div class="containerText">Endpoint</div>
                <div class="line"></div>
                <select class="appTitle" name="endpoint">
                    <optgroup label="General">
                        <option value="authenticate">Authenticate User</option>
                        <option value="validToken">Validate Current Token</option>
                    </optgroup>
                    <optgroup label="Endpoints">
                        <option value="getSources">Get Sources</option>
                        <option value="getChannels">Get Channels</option>
                    </optgroup>
                    <optgroup label="Query Products">
                        <option value="elastic_query">elastic search</option>
                    </optgroup>
                </select>
                <input class='button' type='submit'>
            </form>
            <br><br>
            <div class="conditions">
                <p style="color:black">Add conditions below</p>
                <hr>
                <div>
                <select class='condition-select'>
                    <option>Active</option>
                    <option>Brand</option>
                    <option>Product Type</option>
                    <option>Selling Price</option>
                    <option>Quantity</option>
                </select>
                <select class='condition-select'>
                    <option>equal</option>
                    <option>greater than</option>
                    <option>less than</option>
                    <option>contains</option>
                    <option>does not contain</option>
                </select>
                <input type="text" name='value' autocomplete="off" placeholder='Value' class="condition-select">
                <button class='conditionSubmit' id='true' onclick="Init_function_cond_add_ns(this)">Add</button>
                </div>
            </div>
        </div>
    </div>
</html>

