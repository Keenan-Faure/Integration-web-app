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
                <form method='post' target='_blank' action='output.php'>
                    <br><br><br>
                    <button name='checkConnection' class='buttons' id='b1'><h3 class='buttonText'>Check Connection</h3></button>
                    <br><br>
                    <button name='viewLog'class='buttons' id='b2'><h3 class='buttonText'>View Log</h3></button>
                    <br><br>
                    <button name='visitS2S' class='buttons' id='b3'><h3 class='buttonText'>Visit Stock2Shop</h3></button>
                </form>
            </div>

            <div class='container' id='container-2'>
                <h2 class='h2-hidden'>Products</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='output.php'>
                    <br><br><br>
                    <input type='text' name='getProductBySKU' placeholder='Get Product by SKU' id='b4'></input>
                    <br><br>
                    <button name='getProductBatch' class='buttons' id='b5'><h3 class='buttonText'>Get Products (10)</h3></button>
                    <br><br>
                    <button name='countProducts' class='buttons' id='b6'><h3 class='buttonText'>Count Products</h3></button>
                    <br><br>
                    <button name='viewProductSql' class='buttons' id='b7'><h3 class='buttonText'>View Product Sql</h3></button>
                    <br><br>
                    <button name='addProduct' class='buttons' id='b8'><h3 class='buttonText'>Add Product to Database</h3></button>
                </form>
            </div>

            <div class='container' id='container-3'>
                <h2 class='h2-hidden'>Customers</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='output.php'>
                    <br><br><br>
                    <button name='getCustomer' class='buttons' id='b9'><h3 class='buttonText'>Get Customer by Name</h3></button>
                    <br><br>
                    <button name='CheckConnection' class='buttons' id='b10'><h3 class='buttonText'>Count Customers</h3></button>
                    <br><br>
                    <button name='CheckConnection' class='buttons' id='b11'><h3 class='buttonText'>View Customer Sql</h3></button>
                    <br><br>
                    <button name='CheckConnection' class='buttons' id='b12'><h3 class='buttonText'>Add Customer to Database</h3></button>
                </form>
            </div>
    </body>
        <script src='scripts2.js'></script>
</html>