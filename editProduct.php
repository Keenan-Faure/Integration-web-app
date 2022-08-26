<?php 
    session_start(); 
    include("createConnection.php");
    use Connection\Connection as connect;

?>
<html>
    <head>
        <link rel='stylesheet' href='Styles/addItem.css'>
    </head>
    <body>
        <div class="bg">
        <div class="navBar">
            <div class="overlay">
                <div class='imageNav'></div>
                <h1>Edit Product</h1>
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
                            <a href="editProduct.php">View all products</a>
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

                </div>
            </div>
            <div class='containers' id='maine'>
                <div class='column1'>Active</div>
                <div class='column1' id = 'column2'>SKU</div>
                <div class='column1' id = 'column3'>Title</div>
                <div class='column1' id = 'column4'>Brand</div>
            </div>
        </div>

    </body>
    <script src='Scripts/createElements.js'></script>
    <?php 

        $connection = new connect();
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        //creates query
        
        $query = "SELECT * FROM Inventory";

        $output = $connection->converterObject($rawConnection, $query);
        mysqli_close($rawConnection);
        $_SESSION['products'] = $output;

        for($i = 0; $i < sizeof($_SESSION['products']->result); ++ $i)
        {
            $title = $_SESSION['products']->result[$i]->Title;
            $sku = $_SESSION['products']->result[$i]->SKU;
            $active = $_SESSION['products']->result[$i]->Active;
            $brand = $_SESSION['products']->result[$i]->Brand;
            echo("<script>createPLV('". $active . "','" . $sku . "','" . $title . "','" . $brand . "','" . $sku . "','" . $sku ."');</script>");
        }
        $_SESSION['products'] = sizeof($_SESSION['products']->result);
    ?>
</html>