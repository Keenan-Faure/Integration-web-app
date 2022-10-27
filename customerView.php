<?php 
    
    session_start(); 
    include("createConnection.php");
    use Connection\Connection as connect;
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
        <link rel='stylesheet' href='Styles/productView.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="Scripts/fade.js"></script>
        <script src="Scripts/createElements.js"></script>
        <script src="Scripts/formTransformCust.js"></script>
        <?php 
        
        if(isset($_POST) && (sizeof($_POST) != 0))
        {
            $id = array_keys($_POST)[0];
            $id = ltrim(rtrim($_POST[$id]));
            unset($_POST);

            if($_SESSION['connection'])
            {
                $connection2 = new connect();
                $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query2 = 'select * from Client where id = "' . $id .  '"';
                $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
                $result = json_encode($output2->result[0]);
            }
            //passes the text as a json object
            echo("<script>getCustomerClassNames($result);</script>");
        }
        
        ?>
    </head>
    <body>
        <div class='backgroundtwo'>
        </div>
        <!-- NavBar -->
        <div class="navBar">
            <div class="overlay">
                <div class='imageNav'></div>
                <h1>Simple Product</h1>
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
                <a href="importUtils/import.html" class="buttonOption"></a>

            </div>
        </div>

        <!-- Content -->
        <!-- General -->
        <div class="contentCustomer">
        <form method='post' action='processEdit.php' id='form'>
            <div class='activeC'>
                <input type='checkbox' class='act'>
                <label for='active'>Customer Active</label>
            </div>
            <div class='saveCloseContainer'>
                
                <button class='save' type='submit' title='Save current product'></button>
                <div class='close' type='submit' title='Close and return'></div>
            </div>
            <div class="GeneralContentContainer" id="general">
                <div class="imageSiderC">
                <a class='imageText' title='imageContainer.png' target='_black' href='../Images/customerDemo.wepb'>Demo Image</a>
                </div>
                <div id='imageCompressorC'>
                    <div class='imageContainerC'></div>
                </div>
                <textarea id='textarea' class="titleContainer"></textarea>
                <div class="generalInfoContainer">
                    <div id="gap">
                        <div class="dataContainer">
                            Address 1
                        </div>
                        <textarea id='textarea' class="dataValue ad1"></textarea>
                    </div>

                    <div id="gap">
                        <div class="dataContainer">
                            Address 2
                        </div>
                        <textarea id='textarea' class="dataValue ad2"></textarea>
                    </div>
                    
                    <div id="gap">
                        <div class="dataContainer">
                            Address 3
                        </div>
                        <textarea id='textarea' class="dataValue ad3"></textarea>
                    </div>

                    <div id="gap">
                        <div class="dataContainer">
                            Address 4
                        </div>
                        <textarea id='textarea' class="dataValue ad4"></textarea>
                    </div>
                </div>
                <div class="MetaCustomer">
                    <div class="metaHeader">Attributes</div>
                    <textarea id='textarea' class="meta1 m1"></textarea>
                    <textarea id='textarea' class="meta1 m2"></textarea>
                    <textarea id='textarea' class="meta1 m3"></textarea>
                </div>
            </div>
        </div>
        </form>
    </body>
</html>