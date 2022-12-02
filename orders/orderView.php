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
                <div class='saveCloseContainer'>
                    <textarea id='textarea' class='title'>Order ID: 8907</textarea>
                    <button class='dates'>Show Dates</button>
                    <textarea id='textarea' class='createdDate'> ▶ Created : 2022-11-29T09:04:55Z</textarea>
                    <textarea id='textarea' class='modifiedDate'> ▶ Updated : 2022-11-29T09:04:55Z</textarea>
                    <textarea id='textarea' class='completedDate'> ▶ Completed : 2022-11-29T09:04:55Z</textarea>
                    <div class='status'>
                        Order Status: <button class='orderStatus'>Processing</button>
                    </div>
                    <div class='paymentDetails'>
                        <div class='method'>Payment Details:</div>
                        <div class='hr-1'></div>
                        <div class='method-title'>
                            Payment method: <button class='button-title'>Direct Bank Transfer</button>
                        </div>
                        <div class='payment-status'>
                            Status: <button class='button-status'>Unpaid</button>
                        </div>
                    </div>
                </div>

                <div class="General">
                    <div class="vData" id="vDatad"><p>Order Details</p></div>
                    <div class="vData" id="cData"><p>JSON Data</p></div>
                </div>


                <div class="GeneralContentContainer" id="general">
                    <div class='customerDetailsContainer'>
                        <div class='customerGeneral'>
                            <div class='heading cust-gen'>Customer General Details</div>
                            <hr>
                            <div>
                                <div class='dataField'>
                                    <div class='customer-name gen-val'>ID</div><textarea class='customer-value'>ID</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name gen-val'>First Name</div><textarea class='customer-value'>First Name customer</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name gen-val'>Last Name</div><textarea class='customer-value'>Last name customer</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name gen-val'>Email</div><textarea class='customer-value' id='importDetails'>Email Address</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name gen-val'>Username</div><textarea class='customer-value'>Woocommerce Username</textarea>
                                </div>
                            </div>
                        </div>
                        <div class='customerBilling'>
                            <div class='heading cust-bill'>Customer Billing Details</div>
                            <hr>
                            <div>
                                <div class='dataField'>
                                    <div class='customer-name'>First Name</div><textarea class='customer-value'>billing first name</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Last Name</div><textarea class='customer-value'>billing last name</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Company</div><textarea class='customer-value'>billing company</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Address 1</div><textarea class='customer-value'>billing address 1</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Address 2</div><textarea class='customer-value'>billing address 2</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>City</div><textarea class='customer-value'>billing city</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>State</div><textarea class='customer-value'>billing state</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Phone</div><textarea class='customer-value' id='importDetails'>billing phone</textarea>
                                </div>
                            </div>
                        </div>
                        <div class='customerShipping'>
                            <div class='heading cust-ship'>Customer Shipping Details</div>
                            <hr>
                            <div>
                                <div class='dataField'>
                                    <div class='customer-name'>First Name</div><textarea class='customer-value'>shipping first name</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Last Name</div><textarea class='customer-value'>shipping last name</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Company</div><textarea class='customer-value'>shipping company</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Address 1</div><textarea class='customer-value'>shipping address 1</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Address 2</div><textarea class='customer-value'>shipping address 2</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>City</div><textarea class='customer-value'>shipping city</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>State</div><textarea class='customer-value'>shipping state</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Phone</div><textarea class='customer-value' id='importDetails'>shipping phone</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class='headerLine'></div>
                    <div class='productItemContainer'>

                    </div>
                </div>

            </div> 
    </body>
</html>