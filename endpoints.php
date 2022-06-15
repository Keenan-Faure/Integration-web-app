<html>
    <head>
        <link rel='stylesheet' href='Styles/endpoints.css'>
    </head>
    <body>
            <?php 
            session_start();
            if(!isset($_SESSION['connection']))
            {
                echo('<div class="errors"><p>No Connection found in current session</p></div>');
            }
            ?>
            <div class='background'>
            </div>
            <div class='selfBackground' id='top'>
            </div>

            <h1 id='top'>Custom Query</h1>
            <div class='line' id='top'></div>
            <form method='post' target='_blank' action='endpoint_handler.php' id='top'>
                    <br><br><br>
                    <textarea id='top' class='textarea' name='selfquery' placeholder='Enter your query here'></textarea>
                    <button id='top' type = 'submit' class='enter'>Submit</button>
            </form>

            <h1>Available Endpoints</h1>
            <div class='line'></div>
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
                </form>
            </div>

            <div class='container' id='container-2'>
                <h2 class='h2-hidden'>Products</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <br><br><br>
                    <input type='text' name='getProductBySKU' placeholder='Get Product by SKU' autocomplete="off" id='b4'></input>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <button type='text' name='getProductsBatch' class='button' id='b5'><p class='buttonText'>Get Products (10)</p></button>
                </form>
                
                <form  method='post' target='_blank' action='endpoint_handler.php'>
                    <button class='button' name='countProduct' id='b6'><p class='buttonText'>Count Products</p></button>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <button class='button' name='viewProductSql' id='b7'><p class='buttonText'>View Product Sql queries</p></button>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <button class='button' name='addProduct' id='b8'><p class='buttonText'>Add Product to Database</p></button>               
                </form>
            </div>

            <div class='container' id='container-3'>
                <h2 class='h2-hidden'>Customers</h2>
                <div class='line' id='line-1'></div>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <br><br><br>
                    <input type='text' name='getCustomer' placeholder='Get Customer by Name' autocomplete="off" id='b9'></input>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <button class='button' name='countCustomer' id='b10'><p class='buttonText'>Count Customers</p></button>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                    <button class='button' name='viewCustomerSql' id='b11'><p class='buttonText'>View Customer Sql queries</p></button>
                </form>
                <form method='post' target='_blank' action='endpoint_handler.php'>
                <button class='button' name='addCustomer' id='b12'><p class='buttonText'>Add Customer to Database</p></button> 
                </form>
            </div>
    </body>
        <script src='scripts2.js'></script>
</html>