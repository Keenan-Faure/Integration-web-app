<?php 
    
    session_start(); 
    include("../Class Templates/createConnection.php");
    include("../Class Templates/utility.php");

    use Connection\Connection as connect;
    use utils\Utility as util;
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="../Images/logo.png"/>
        <link rel='stylesheet' href='../Styles/orderView.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../Scripts/createElements.js"></script>
        <?php 
        
        if(isset($_POST) && (sizeof($_POST) != 0))
        {
            $id = array_keys($_POST)[0];
            $id = ltrim(rtrim($_POST[$id]));
            unset($_POST);

            if($_SESSION['connection'])
            {
                $connection2 = new connect();
                $util = new util();
                $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query2 = 'select * from Orders where ID = "' . $id .  '"';
                $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
                // $body_html = 'Description';
                // $output2->result[0]->$body_html = stripslashes(html_entity_decode($output2->result[0]->$body_html));

                //unserialize values
                if(sizeof($output2->result) > 0)
                {
                    $result = $util->unserializeOrder($output2->result);
                }

                $result = json_encode($output2->result[0]);
            }
            //passes the text as a json object
            //echo("<script>getClassNames($result, '$type');</script>");
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
                                <a href="../endpoints.php">Dashboard</a>
                            </div>
                        </div>
                    </div>
                    <div class='buttonContainer'>
                    <div class="dropDown">
                    <button class="dropDownBtn">Products</button>
                        <div class="dropDownContent">
                            <a href="../products/addItem.html">Add Product</a>
                            <a href="../products/productList.php?page=1">View all products</a>
                            <a href="../importUtils/import.html">Import Products</a>
                            <a href="../importUtils/productExport.php">Export Products</a>
                        </div>
                    </div>
    
                        <div class="dropDown">
                        <button class="dropDownBtn">Customers</button>
                            <div class="dropDownContent">
                                <a href="../customers/addCustomer.html">Add Customer</a>
                                <a href="../customers/customerList.php">View Customers</a>
                            </div>
                        </div>
                    </div>
                    <a href="../importUtils/import.html" class="buttonOption"></a>
                    </div>
                </div>
            </div>
            <div class="orderContainer">
                <textarea id='textarea' class='title'>Order ID: 8907</textarea>
                <div class='status'>
                    Order Status: <button class='orderStatus'>Processing</button>
                </div>
                <div class='headerLine'></div>
                <div class='customerDetailsContainer'>

                </div>
            </div> 
    </body>
</html>