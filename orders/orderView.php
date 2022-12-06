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
        <script src="../Scripts/fade-orders.js"></script>
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
                echo("<script>console.log($result);</script>");
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
            <div class="orderContainer">
                <div class='saveCloseContainer'>
                    <textarea id='textarea' class='title'>order.order_id</textarea>
                    <button class='dates'>Show Dates</button>
                    <textarea id='textarea' class='createdDate'> ▶ Created : . order.created_at</textarea>
                    <textarea id='textarea' class='modifiedDate'> ▶ Updated : order.updated_at</textarea>
                    <textarea id='textarea' class='completedDate'> ▶ Completed : order.completed_at</textarea>
                    <div class='status'>
                        Order Status: <button class='orderStatus'>order.status</button>
                    </div>
                    <div class='paymentDetails'>
                        <div class='method'>Payment Details:</div>
                        <div class='hr-1'></div>
                        <div class='method-title'>
                            Payment method: <button class='button-title'>order.payment_details.method_title</button>
                        </div>
                        <div class='payment-status'>
                            Status: <button class='button-status'>order.payment_details.paid</button>
                        </div>
                    </div>
                </div>

                <div class="General">
                    <div class="vData" id="vDatad"><p>Order Details</p></div>
                    <div class="vData" id="cData"><p>Customer data</p></div>
                    <div class="vData" id="jData"><p>JSON Data</p></div>
                </div>

                <!-- General order data -->
                <div class="GeneralContentContainer" id="general">
                    <div class='productItemContainer'>
                        <hr>
                        <div class='headers-head'>
                            <div class='headers' id='product'>Product</div>
                            <div class='headers' id='price'>Price</div>
                            <div class='headers' id='amount'>Amount</div>
                            <div class='headers' id='total'>Total</div>
                            <div class='headers' id='vat'>VAT</div>
                        </div>
                        <div class='data'>
                            <div class='pData' id='product'>
                                <div class='imageContainer'>
                                    <img class='image' src='../Images/image1.png'>
                                </div>
                                <div class='dataContainer'>
                                    <div class='dataValues orderTitle'><b>Title:</b> Balled of Goblets - Venti</div>
                                    <div class='dataValues sku'><b>SKU:</b> GenImp-V-AA</div>
                                    <div class='dataValues meta'></div>
                                </div>
                            </div>
                            <div class='priced' id='price'>R1700</div>
                            <div class='amountd' id='amount'>&times; 1</div>
                            <div class='totald' id='total'>R1700</div>
                            <div class='vatd' id='vat'>R175</div>
                        </div>
                        <div class='data'>
                            <div class='pData' id='product'>
                                <div class='imageContainer'>
                                    <img class='image' src='../Images/image1.png'>
                                </div>
                                <div class='dataContainer'>
                                    <div class='dataValues orderTitle'><b>Title: </b> Violet - Yae Miko</div>
                                    <div class='dataValues sku'><b>SKU:</b> GenImp-Y-EC</div>
                                    <div class='dataValues meta'></div>
                                </div>
                            </div>
                            <div class='priced' id='price'>R1500</div>
                            <div class='amountd' id='amount'>&times; 2</div>
                            <div class='totald' id='total'>R3000</div>
                            <div class='vatd' id='vat'>R155</div>
                        </div>
                        <div class='data'>
                            <div class='pData' id='product'>
                                <div class='imageContainer'>
                                    <img class='image' src='../Images/ship.jpeg'>
                                </div>
                                <div class='dataContainer'>
                                    <div class='dataValues shipTitle'><b>Title:</b> Shipping methods</div>
                                </div>
                            </div>
                            <div class='priced' id='price'></div>
                            <div class='amountd' id='amount'></div>
                            <div class='total_shipd' id='total'>total_shipping</div>
                            <div class='ship_vatd' id='vat'>shipping_tax</div>
                        </div>
                    </div>
                    <hr>
                    <div class='calc'>
                        <table>
                            <tr>
                                <th>Subtotal:</th>
                                <th class='subtotal'>Value</th>
                            </tr>
                            <tr>
                                <th>VAT:</th>
                                <th class='vattotal'>Value</th>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <th class='total'>Value</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Customer order data -->
                <div class='GeneralContentContainer' id='customer'>
                    <div class='customerDetailsContainer'>
                        <div class='customerGeneral'>
                            <div class='heading cust-gen'>Customer General Details</div>
                            <hr>
                            <div>
                                <div class='dataField'>
                                    <div class='customer-name'>ID</div><textarea class='customer-value cust-id'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>First Name</div><textarea class='customer-value cust-fname'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Last Name</div><textarea class='customer-value custlname'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Email</div><textarea class='customer-value cust-email' id='importDetails'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Username</div><textarea class='customer-value cust-uname'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='customerBilling'>
                            <div class='heading'>Customer Billing Details</div>
                            <hr>
                            <div>
                                <div class='dataField'>
                                    <div class='customer-name'>First Name</div><textarea class='customer-value bill-fname'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Last Name</div><textarea class='customer-value bill-lname'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Company</div><textarea class='customer-value bill-comp'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Address 1</div><textarea class='customer-value bill-addr1'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Address 2</div><textarea class='customer-value bill-addr2'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>City</div><textarea class='customer-value bill-city'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>State</div><textarea class='customer-value bill-state'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Phone</div><textarea class='customer-value bill-cell' id='importDetails'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='customerShipping'>
                            <div class='heading'>Customer Shipping Details</div>
                            <hr>
                            <div>
                                <div class='dataField'>
                                    <div class='customer-name'>First Name</div><textarea class='customer-value ship-fname'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Last Name</div><textarea class='customer-value ship-lname'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Company</div><textarea class='customer-value ship-comp'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Address 1</div><textarea class='customer-value ship-addr1'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Address 2</div><textarea class='customer-value ship-addr2'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>City</div><textarea class='customer-value ship-city'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>State</div><textarea class='customer-value ship-state'></textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Phone</div><textarea class='customer-value ship-cell' id='importDetails'></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- JSON order data -->
                <div class="GeneralContentContainer" id="json">
                    <pre class='jsonText'>
                    </pre>
                </div>
            </div> 
    </body>
</html>