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
                            <a href="addCustomer.php">Add Customer</a>
                            <a href="editCustomer.php">View Customers</a>
                        </div>
                    </div>
                </div>

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

                </div>
            </div>
            <div class='containers' id='main'>
                <textarea id = 'smaller' class='typeE'>Customer Attribute</textarea>
                <textarea id = 'smaller' class='prev'>Current Value</textarea>
                <textarea id = 'smaller' class='current'>Editable Value</textarea>
                <form id='form' action='processEdit.php' method='post'></form>
            </div>
        </div>

    </body>
    <script src='Scripts/createElements.js'></script>
    <?php 
        if(isset($_SESSION['customers']))
        {
            $id = array_keys($_POST)[0];
            unset($_POST);
            if($_SESSION['connection'])
            {
                $connection2 = new connect();
                $rawConnection = $connection2->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query2 = 'select * from Client where ID = "' . $id .  '"';
                $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);
                
                $_SESSION['edit_cust'] = new \stdClass();
                
                $customerTemplateDB = array('ID','Name', 'Surname', 'Email', 'Address_1', 'Address_2', 'Address_3', 'Address_4', 'submit');
                $customerTemplateForm = array('id','name', 'surname', 'email', 'address1', 'address2', 'address3', 'address4', 'submit');

                //loop through template list...
                $notUsed = array();
                for($j = 0; $j < sizeof($customerTemplateDB); ++ $j)
                {
                    $templateDB = $customerTemplateDB[$j];
                    $template = $customerTemplateForm[$j];
                    if($template == 'submit' && !(isset($output2->result[0]->$template)))
                    {
                        //if its the last item in the list
                        echo("<script>createSumbit()</script>");
                    }
                    else if($template == 'id')
                    {
                        $_SESSION['edit_cust']->$template = $output2->result[0]->$templateDB;
                    }
                    else
                    {
                        if(isset($output2->result[0]->$templateDB) && $output2->result[0]->$templateDB != null)
                        {
                            $_SESSION['edit_cust']->$template = $output2->result[0]->$templateDB;
                            echo("<script>createTA('prev', 'current','" . $output2->result[0]->$templateDB . "','" . $template . "','" . $templateDB . "');</script>");
                        }
                        else
                        {
                            $var = 'null';
                            echo("<script>createTA('prevNA', 'currentNA','" . $var . "','" . $template . "','" . $templateDB . "');</script>");
                        }
                    }
                }
            }
        } 
    ?>
</html>