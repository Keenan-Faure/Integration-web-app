<?php 
    session_start(); 
    include("createConnection.php");
    use Connection\Connection as connect;

?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
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
                            <a href="endpoints.php">Dashboard</a>
                        </div>
                    </div>
                </div>
                <div class='buttonContainer'>
                    <div class="dropDown">
                    <button class="dropDownBtn">Products</button>
                        <div class="dropDownContent">
                            <a href="addItem.html">Add Product</a>
                            <a href="productList.php?page=1">View all products</a>
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

                </div>
            </div>
            <div class='containers' id='maine'>
                <div class='column1'>Active</div>
                <div class='column1' id = 'column2'>Name</div>
                <div class='column1' id = 'column3'>Surname</div>
                <div class='column1' id = 'column4'>Email</div>
            </div>
        </div>

    </body>
    <script src='Scripts/createElements.js'></script>
    <?php 
        $connection = new connect();
        $rawConnection = $connection->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
        //creates query
        
        $query = "SELECT * FROM Client";

        $output = $connection->converterObject($rawConnection, $query);
        mysqli_close($rawConnection);
        $_SESSION['customers'] = $output;

        for($i = 0; $i < sizeof($_SESSION['customers']->result); ++ $i)
        {
            //loop through template list...
            $name = $_SESSION['customers']->result[$i]->Name;
            $surname = $_SESSION['customers']->result[$i]->Surname;
            $active = $_SESSION['customers']->result[$i]->Active;
            $email = $_SESSION['customers']->result[$i]->Email;
            $id = $_SESSION['customers']->result[$i]->ID;
            echo("<script>createCLV('". $active . "','" . $name . "','" . $surname . "','" . $email . "','" . $id . "');</script>");
        }
        $_SESSION['customers'] = sizeof($_SESSION['customers']->result);
    ?>
</html>