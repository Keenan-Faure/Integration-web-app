<?php 
    
    session_start(); 
    include("../Class Templates/createConnection.php");
    use Connection\Connection as connect;
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="../Images/logo.png"/>
        <link rel='stylesheet' href='../Styles/productView.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../Scripts/fade.js"></script>
        <script src="../Scripts/createElements.js"></script>
        <script src="../Scripts/formTransform.js"></script>
        <?php 
        
        if(isset($_POST) && (sizeof($_POST) != 0))
        {
            $sku = array_keys($_POST)[0];
            $sku = ltrim(rtrim($_POST[$sku]));
            unset($_POST);

            if($_SESSION['connection'])
            {
                $connection2 = new connect();
                $rawConnection = $connection2->createConnection($_SESSION['connection']->credentials->username, $_SESSION['connection']->credentials->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query2 = 'select * from Inventory where SKU = "' . $sku .  '"';
                $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
                $body_html = 'Description';
                $output2->result[0]->$body_html = stripslashes(html_entity_decode($output2->result[0]->$body_html));
                $type = $output2->result[0]->Type;
                $result = json_encode($output2->result[0]);
            }
            //passes the text as a json object
            echo("<script>getClassNames($result, '$type');</script>");
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
                            <a href="../endpoints.php">Dashboard</a>
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
                            <a href="addItem.html">Add Product</a>
                            <a href="productList.php?page=1">View all products</a>
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

        <!-- Content -->
        <!-- General -->
        <div class="content">
        <form method='post' action='../bin/controllers/processEdit.php' id='form'>
            <div class='active'>
                <input type='checkbox' class='act'>
                <label for='active'>Product Active</label>
            </div>
            <div class='saveCloseContainer'>
                
                <button class='save' type='submit' title='Save current product'></button>
                <div class='close' type='submit' title='Close and return'></div>
            </div>
            <div class="General">
                <div class="vData" id="vDatad"><p>General</p></div>
                <div class="vData" id="gData"><p>Variant</p></div>
                <div class="vData" id="cData"><p>Connectors</p></div>
            </div>
            <div class="GeneralContentContainer" id="general">
                <div class="imageSider">
                <a class='imageText' title='imageContainer.png' target='_black' href='../Images/imageContainer.png'>Demo Image</a>
                </div>
                <div id='imageCompressor'>
                    <div class='imageContainer'></div>
                </div>
                <textarea id='textarea' class="titleContainer"></textarea>
                <div class="generalInfoContainer">
                    <div id="gap">
                        <div class="dataContainer">
                            Vendor
                        </div>
                        <textarea id='textarea' class="dataValue vd"></textarea>
                    </div>

                    <div id="gap">
                        <div class="dataContainer">
                            Collection
                        </div>
                        <textarea id='textarea' class="dataValue cl"></textarea>
                    </div>
                    
                    <div id="gap">
                        <div class="dataContainer">
                            Product Type
                        </div>
                        <textarea id='textarea' class="dataValue pt"></textarea>
                    </div>
                </div>
                <div class="Meta">
                    <div class="metaHeader">Attributes</div>
                    <textarea id='textarea' class="meta1 m1"></textarea>
                    <textarea id='textarea' class="meta1 m2"></textarea>
                    <textarea id='textarea' class="meta1 m3"></textarea>
                </div>
                <div contenteditable="true" id='textarea' name='description' class="longDescriptionContainer">
                    <div class="longDescHeader">Long Description</div>
                </div>
            </div>
            <!-- Variant -->
            <div class="GeneralContentContainer" id="variant">
                <div class="variantData">
                    <div class="headers">SKU</div>
                    <textarea contenteditable="true" id='textarea' class="sku s"></textarea>
                    <br><br>
                    <div class="headers">Variant Code</div>
                    <textarea contenteditable="true" id='textarea' class="sku vc"></textarea>
                    <br><br>
                    <div class="headers">Product Code</div>
                    <textarea contenteditable="true" id='textarea' class="sku pc"></textarea>
                    <br><br>
                    <div class="headers">Barcode</div>
                    <textarea contenteditable="true" id='textarea' class="sku bc"></textarea>
                </div>
                <div class="priceQuantity">
                <div class="priceQuantityHeader">Price and Quantity</div>
                <br><br>
                    <div class="priceQ">Compare To Price</div>
                    <textarea contenteditable="true" id='textarea' class="priceQValue ctp"></textarea>
                    <div class="priceQ">Selling Price</div>
                    <textarea contenteditable="true" id='textarea' class="priceQValue sp"></textarea>
                    <div class="priceQ ">Cape Town Warehouse</div>
                    <textarea contenteditable="true" id='textarea' class="priceQValue q"></textarea>
                </div>
                <div class="weight">
                    <div class="weightHeader">Weight (grams)</div>
                    <br><br>
                    <div class="weighter">Weight</div>
                    <textarea contenteditable="true" id='textarea' class="weightValue wv"></textarea>
                </div>
                <div class="Option">
                    <div class="optionHeader">Options</div>
                    <br><br>
                    <textarea contenteditable="true" id='textarea' class="option1 on1"></textarea>
                    <textarea contenteditable="true" id='textarea' class="option1 on2"></textarea>
                    <textarea contenteditable="true" id='textarea' class="option1 ov1"></textarea>
                    <textarea contenteditable="true" id='textarea' class="option1 ov2"></textarea>
                </div>
            </div>
            <!-- Connector -->
            <div class="GeneralContentContainer" id="connector">
                <div class="connector">
                    <div class="connectorHeading">Woocommerce IDs</div>
                    <br><br>
                        <div class="connectorText">Product ID</div>
                        <textarea contenteditable="true" id='textarea' class="connectorValue p_id"></textarea>
                        <div class="connectorText">Variant ID</div>
                        <textarea contenteditable="true" id='textarea' class="connectorValue v_id"></textarea>
                </div>
                <div class="connector" id='stock2shopPushed'>
                    <div class="connectorHeading">Stock2Shop active</div>
                    <br><br>
                        <div class="connectorText">Stock2Shop</div>
                        <textarea contenteditable="true" id='textarea' class="stock2shopValue s2s_active"></textarea>
                </div>
            </div>
        </div>
        <textarea id='holder' style='width: 0;height:0' name='description'></textarea>
        <p class="auditTrail"></p>
        </form>
    </body>
</html>