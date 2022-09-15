<?php 
    
    session_start(); 
    include("createConnection.php");
    use Connection\Connection as connect;
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="Images/logo.png"/>
        <link rel='stylesheet' href='Styles/viewItem.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="Scripts/fade.js"></script>
        <script src="Scripts/createElements.js"></script>
        <?php 
        
        if(isset($_POST) && (sizeof($_POST) != 0))
        {
            $sku = array_keys($_POST)[0];
            $sku = ltrim(rtrim($_POST[$sku]));
            unset($_POST);

            if($_SESSION['connection'])
            {
                $connection2 = new connect();
                $rawConnection = $connection2->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query2 = 'select * from Inventory where SKU = "' . $sku .  '"';
                $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
                $body_html = 'Description';
                $output2->result[0]->$body_html = stripslashes(html_entity_decode($output2->result[0]->$body_html));
                $result = json_encode($output2->result[0]);
            }
            //passes the text as a json object
            echo("<script>getClassNames($result);</script>");
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
                <a href="importUtils/import.html" class="buttonOption"></a>

            </div>
        </div>

        <!-- Content -->
        <!-- General -->
        <div class="content">
            <div class="General">
                <div class="vData" id="vDatad"><p>General</p></div>
                <div class="vData" id="gData"><p>Variant</p></div>
            </div>
            <div class="GeneralContentContainer" id="general">
                <div class="imageSider">
                </div>
                <div class='imageContainer'></div>
                <div class="titleContainer"></div>
                <div class="generalInfoContainer">
                    <div id="gap">
                        <div class="dataContainer">
                            Vendor
                        </div>
                        <div class="dataValue vd"></div>
                    </div>

                    <div id="gap">
                        <div class="dataContainer">
                            Collection
                        </div>
                        <div class="dataValue cl"></div>
                    </div>
                    
                    <div id="gap">
                        <div class="dataContainer">
                            Product Type
                        </div>
                        <div class="dataValue pt"></div>
                    </div>
                </div>
                <div class="metaHeader">Attributes</div>
                <div class="Meta">
                    <div class="meta1 m1"></div>
                    <div class="meta1 m2"></div>
                    <div class="meta1 m3"></div>
                </div>
                <div class="longDescHeader">Long Description</div>
                <div class="longDescriptionContainer"></div>
            </div>
            <!-- Variant -->
            <div class="GeneralContentContainer" id="variant">
                <div class="variantData">
                    <div class="headers">SKU</div>
                    <div class="sku s"></div>
                    <br><br>
                    <div class="headers">Variant Code</div>
                    <div class="sku vc"></div>
                    <br><br>
                    <div class="headers">Product Code</div>
                    <div class="sku pc"></div>
                    <br><br>
                    <div class="headers">Barcode</div>
                    <div class="sku bc"></div>
                </div>
                <div class="priceQuantityHeader">Price and Quantity</div>
                <div class="priceQuantity">
                    <div class="priceQ">Compare To Price</div>
                    <div class="priceQValue ctp"></div>
                    <div class="priceQ">Selling Price</div>
                    <div class="priceQValue sp"></div>
                    <br><br>
                    <div class="priceQ ">Cape Town Warehouse</div>
                    <div class="priceQValue q"></div>
                </div>
                <div class="weightHeader">Weight (grams)</div>
                <div class="weight">
                    <div class="weighter">Weight</div>
                    <div class="weightValue wv"></div>
                </div>
                <div class="optionHeader">Options</div>
                <div class="Option">
                    <div class="option1 on1"></div>
                    <div class="option1 on2"></div>
                    <div class="option1 ov1"></div>
                    <div class="option1 ov2"></div>
                </div>
            </div>
        </div>
    </body>
</html>