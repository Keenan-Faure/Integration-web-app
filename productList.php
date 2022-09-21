<?php 
    session_start(); 
    include("createConnection.php");
    use Connection\Connection as connect;

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="Styles/productList.css">
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="Scripts/fade.js"></script>
        <script src="Scripts/createElements.js"></script>
        <?php 
        if($_SESSION['connection'])
        {
            $connection2 = new connect();
            $rawConnection = $connection2->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
            $query2 = 'SELECT * FROM Inventory';
            $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
            $result = json_encode($output2->result);
            echo("<script>initiatorCreateProducts($result);</script>");
        }
        ?>
    </head>
    <body>
        <div class='backgroundtwo'>
            <div class="navBar">
                <div class="overlay">
                    <div class='imageNav'></div>
                    <h1>Edit Products</h1>
                    <div class='buttonContainer2'>
                        <div class="dropDown">
                        <button class="dropDownBtn">Home</button>
                            <div class="dropDownContent">
                                <a href="serverData.php">Dashboard</a>
                            </div>
                        </div>
    
                        <div class="dropDown">
                        <button class="dropDownBtn">Endpoints</button>
                            <div class="dropDownContent">
                                <a href="endpoints.php">View Endpoints</a>
                                <a href="API/document.html" target='_blank'>API</a>
                            </div>
                        </div>
                    </div>
                    <div class='buttonContainer'>
                    <div class="dropDown">
                    <button class="dropDownBtn">Products</button>
                        <div class="dropDownContent">
                            <a href="addItem.html">Add Product</a>
                            <a href="productList.php">View all products</a>
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
                <div class="containerNew">
                    <div class="containerHeaders">
                        <div class="imageContainer">Image</div>
                        <div class="sku">sku</div>
                        <div class="title">title</div>
                        <div class="category">collection</div>
                        <div class="vendor">Vendor</div>
                    </div>
                    
                    <hr>
                    <form method='post' action='productView.php' id='productForm'>
                    </form>
                </div>
            </div>
    </body>
</html>