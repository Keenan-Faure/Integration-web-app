<?php 
    session_start(); 
    include("../Class Templates/createConnection.php");
    use Connection\Connection as connect;
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../Styles/productList.css">
        <link rel="icon" type="image/x-icon" href="../Images/logo.png"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../Scripts/fade.js"></script>
        <script src="../Scripts/createElements.js"></script>
        <script src="../Scripts/fetch.js"></script>
        <script src="../Scripts/fetchUtils.js"></script>
        <?php 
        if(isset($_SESSION['connection']))
        {
            $connection2 = new connect();
            $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
            
            //gets the url
            $host = "http://" . $_SERVER['HTTP_HOST']; //needs to be defined
            $fullUrl = $_SERVER["REQUEST_URI"];
            $fullUrl = $host . $fullUrl;
            $page = ($connection2->queryParams($fullUrl))['page'];

            //Queries the param found in the URL
            $query2 = 'SELECT * FROM Client LIMIT ' . (($page-1) * 10) . ', ' . (10);
            $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
            $result = json_encode($output2->result);
            echo("<script>initiatorCreateCustomers($result);</script>");
        }
        ?>
    </head>
    <body onclick="inFocus()">
        <div class='backgroundtwo'>
            <div class="navBar">
                <div class="overlay">
                    <div class='imageNav'></div>
                    <h1>Edit Products</h1>
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
                            <a href="../addItem.html">Add Product</a>
                            <a href="../products/productList.php?page=1">View all products</a>
                            <a href="../importUtils/import.html">Import Products</a>
                            <a href="../importUtils/productExport.php">Export Products</a>
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
                    <!-- Search -->
                    <div id='search-b-h'>
                            <div class='search-bar'>
                                <input class='search-field' type='text' placeholder='Search...'>
                                <button class='search-btn' onclick="Init_function_srch('cust')"  type='submit'></button>
                            </div>
                            <div class='search-result-container'>
                                Search results
                                <hr>
                                <br>
                                <form method='post' action='customerView.php' id='productSForm'>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="containerNew">
                    <div class="containerHeaders">
                        <div class="imageContainer">Image</div>
                        <div class="sku">ID</div>
                        <div class="title">Name</div>
                        <div class="category">Surname</div>
                        <div class="vendor">Email Address</div>
                    </div>
                    <hr>
                    <form method='post' action='customerView.php' id='customerForm'>
                    </form>
                </div>
                <div class="bottom">
                    <div class='pagination'></div>
                </div>
            </div>
            <?php
                if(isset($_SESSION['connection']))
                {
                    //create the <a> tags using php
                    //calculate the number of page numbers
                    $_SESSION['pagination'] = $connection2->pagination($rawConnection, "Client");

                    if(isset($_SESSION['pagination']))
                    {
                        $number = $_SESSION['pagination'];
                        $url = $host . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
                        echo("<script>createPagination($number, '$url', $page)</script>");
                    }
                }
            ?>
    </body>
</html>