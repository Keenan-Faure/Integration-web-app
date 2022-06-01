<?php
    unset($_POST);
?>
<html>
    <head>
        <link rel='stylesheet' href='Styles/endpoints.css'>
    </head>
    <body>
            <div class='background'>
            </div>
            <h1>Available Endpoints</h1>
            <div class='line'></div>
            <div class='container' id='container-1'>
                <h2 class='h2-hidden'>General</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='API.php'>
                    <br><br><br>
                    <button name='checkConnection' class='button' id='b1'><p class='buttonText'>Check Connection</p></button>
                    <br><br>
                    <button name='viewLog'class='button' id='b2'><p class='buttonText'>View Log</p></button>
                    <br><br>
                    <button name='visitS2S' class='button' id='b3'><p class='buttonText'>Visit Stock2Shop</p></button>
                </form>
            </div>

            <div class='container' id='container-2'>
                <h2 class='h2-hidden'>Products</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='API.php'>
                    <br><br><br>
                    <input type='text' name='getProductBySKU' placeholder='Get Product by SKU' autocomplete="off" id='b4'></input>
                </form>

                <form method='post' target='_blank' action='API.php'>
                    <input type='text' name='getProductsBatch' placeholder='Get Products (10)' autocomplete="off" id='b5'></input>
                </form method='post' target='_blank' action='API.php'>

                <form  method='post' target='_blank' action='API.php'>
                    <input type='text' name='countProducts' placeholder='Count Products' autocomplete="off" id='b6'></input>
                <form method='post' target='_blank' action='API.php'>
                <br><br>
                <button class='button' name='viewProductSql' id='b7'><p class='buttonText'>View Product Sql queries</p></button>
                <br><br>
                <form method='post' target='_blank' action='API.php'>
                    <input type='text' name='addProduct' placeholder='Add Product to Database' autocomplete="off" id='b8'></input>
                </form>
            </div>

            <div class='container' id='container-3'>
                <h2 class='h2-hidden'>Customers</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='API.php'>
                    <br><br><br>
                    <input type='text' name='getCustomer' placeholder='Get Customer by Name' autocomplete="off" id='b9'></input>
                    <br><br>
                    <input type='text' name='countCustomer' placeholder='Count Customers' autocomplete="off" id='b10'></input>
                    <br><br>
                    <button class='button' name='viewCustomerSql' id='b11'><p class='buttonText'>View Customer Sql queries</p></button>
                    <br><br>
                    <input type='text' name='addCustomer' placeholder='Add Customer to Database' autocomplete="off" id='b12'></input>
                </form>
            </div>
    </body>
        <script src='scripts2.js'></script>
</html>