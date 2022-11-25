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
        <script src="../Scripts/app.js"></script>
    </head>
    <body>
    <div class='backgroundApp'>
    <div class="errorTable">
        <div class="errors"><p class="align">Hover for more information</p></div>
        <br>
        <div class="errors" id="push"><p class="align">Configure Conditions for push</p></div>
        <br>
        <form method="post" action="addCondition.php">
            <div class="conditions">
            <p style="color:black">Add conditions below</p>
            <select class='condition-select' name="dataValue">
                <option value="Active">Active</option>
                <option value="Brand">Brand</option>
                <option value="Product_Type">Product Type</option>
                <option value="SellingPrice">Selling Price</option>
                <option value="CapeTown_Warehouse">Quantity</option>
            </select>
            <select class='condition-select' name="condition">
                <option value="=">=</option>
                <option value=">">></option>
                <option value="<"><</option>
                <option value=">=">>=</option>
                <option value="<=>"><=</option>
            </select>
            <input type="text" name='value' placeholder='Value' class="condition-select">
            <input class='conditionSubmit' type="submit">
            </div>
        </form>
        <br>
        <form method="post" action="addCondition.php">
            <div class="conditions">
            <p style="color:black">Remove Condition</p>
            <select class='condition-select' name="dataValueRemove">
                <option value="Active">Active</option>
                <option value="Brand">Brand</option>
                <option value="Product_Type">Product Type</option>
                <option value="SellingPrice">Selling Price</option>
                <option value="CapeTown_Warehouse">Quantity</option>
            </select>
            <select class='condition-select' name="conditionRemove">
                <option value="=">=</option>
                <option value=">">></option>
                <option value="<"><</option>
                <option value=">=">>=</option>
                <option value="<=>"><=</option>
            </select>
            <input type="text" name='valueRemove' placeholder='Value' class="condition-select">
            <input class='conditionSubmit' type="submit">
            </div>
        </form>
    </div>
    <div class='conditionTable'>
        <h1 class='header'>Conditions</h1>
        <?php
            for($i = 0; $i < sizeof($output->result); ++$i)
            {
                $iteration = $output->result[$i];
                echo("<div class='condition'><p class='align'>$iteration->DataValue $iteration->Conditions $iteration->Value</p></div>");
                echo("<br>");
            }
        ?>
    </div>
    <div class="navBar">
                <div class="overlay">
                    <div class='imageNav'></div>
                    <h1>Stock2Shop App</h1>
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
                                <a href="../customers/addCustomer.html">Add Customer</a>
                                <a href="../editCustomer.php">View Customers</a>
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
        </div>
    </div>
</html>

