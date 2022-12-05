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
                            <div class='headers' id='id'>Total</div>
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
                            <div class='idd' id='id'>R1700</div>
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
                            <div class='idd' id='id'>R3000</div>
                            <div class='vatd' id='vat'>R155</div>
                        </div>
                    </div>
                    <hr>
                    <div class='calc'>
                        <div class='calcText'>Subtotal: R4500.00</div>
                        <div class='calcText'>VAT: R325.00</div>
                        <div class='calcText'>Total: R4835.00</div>
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
                                    <div class='customer-name'>ID</div><textarea class='customer-value'>ID</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>First Name</div><textarea class='customer-value'>First Name customer</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Last Name</div><textarea class='customer-value'>Last name customer</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Email</div><textarea class='customer-value' id='importDetails'>Email Address</textarea>
                                </div>
                                <div class='dataField'>
                                    <div class='customer-name'>Username</div><textarea class='customer-value'>Woocommerce Username</textarea>
                                </div>
                            </div>
                        </div>
                        <div class='customerBilling'>
                            <div class='heading'>Customer Billing Details</div>
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
                            <div class='heading'>Customer Shipping Details</div>
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
                </div>
                <!-- JSON order data -->
                <div class="GeneralContentContainer" id="json">
                    <pre class='jsonText'>
{
    "order": {
        "id": 7002,
        "order_number": "7002",
        "order_key": "wc_order_HVoFnY3EmPAeq",
        "created_at": "2022-11-29T09:04:55Z",
        "updated_at": "2022-12-02T07:03:38Z",
        "completed_at": "1970-01-01T00:00:00Z",
        "status": "pending",
        "currency": "ZAR",
        "total": "920.00",
        "subtotal": "800.00",
        "total_line_items_quantity": 1,
        "total_tax": "120.00",
        "total_shipping": "0.00",
        "cart_tax": "120.00",
        "shipping_tax": "0.00",
        "total_discount": "0.00",
        "shipping_methods": "",
        "payment_details": {
            "method_id": "bacs",
            "method_title": "Direct bank transfer",
            "paid": false
        },
        "billing_address": {
            "first_name": "Keenan",
            "last_name": "Faure",
            "company": "Hoyoverse",
            "address_1": "14 Tracy Close",
            "address_2": "Montrose Park",
            "city": "Cape Town",
            "state": "WC",
            "postcode": "7785",
            "country": "ZA",
            "email": "keenan@stock2shop.com",
            "phone": "0123456781"
        },
        "shipping_address": {
            "first_name": "Keenan",
            "last_name": "Faure",
            "company": "Hoyoverse",
            "address_1": "14 Tracy Close",
            "address_2": "Montrose Park",
            "city": "Cape Town",
            "state": "WC",
            "postcode": "7785",
            "country": "ZA"
        },
        "note": "I am a note",
        "customer_ip": "",
        "customer_user_agent": "",
        "customer_id": 10,
        "view_order_url": "https://s2s.ucc.co.za/my-account/view-order/7002/",
        "line_items": [
            {
                "id": 333,
                "subtotal": "800.00",
                "subtotal_tax": "120.00",
                "total": "800.00",
                "total_tax": "120.00",
                "price": "800.00",
                "quantity": 1,
                "tax_class": "",
                "name": "Database Software V10 - N/A",
                "product_id": 4233,
                "sku": "DB/9/0/10",
                "meta": [
                    {
                        "key": "option-1",
                        "value": "N/A",
                        "label": "Option 1"
                    }
                ]
            }
        ],
        "shipping_lines": [],
        "tax_lines": [
            {
                "id": 334,
                "rate_id": 1,
                "code": "ZA-VAT-1",
                "title": "VAT",
                "total": "120.00",
                "compound": false
            }
        ],
        "fee_lines": [],
        "coupon_lines": [],
        "customer": {
            "id": 10,
            "created_at": "2022-04-07T07:40:24Z",
            "last_update": "2022-11-09T14:47:13Z",
            "email": "keenan@stock2shop.com",
            "first_name": "Keenan",
            "last_name": "Faure",
            "username": "keenan",
            "role": "administrator",
            "last_order_id": 7002,
            "last_order_date": "2022-11-29T09:04:55Z",
            "orders_count": 39,
            "total_spent": "49288.35",
            "avatar_url": "https://secure.gravatar.com/avatar/81e08af00c5dfe8fb493d09ba1163d98?s=96&d=mm&r=g",
            "billing_address": {
                "first_name": "Keenan",
                "last_name": "Faure",
                "company": "Easy",
                "address_1": "14 Tracy Close",
                "address_2": "",
                "city": "Cape Town",
                "state": "WC",
                "postcode": "7785",
                "country": "ZA",
                "email": "keenan@stock2shop.com",
                "phone": ""
            },
            "shipping_address": {
                "first_name": "Keenan",
                "last_name": "Faure",
                "company": "Easy",
                "address_1": "14 Tracy Close",
                "address_2": "",
                "city": "Cape Town",
                "state": "WC",
                "postcode": "7785",
                "country": "ZA"
            }
        }
    }
}
                    </pre>
                </div>
            </div> 
    </body>
</html>