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
            <div class="overlay">
                <h1>Edit Customer</h1>
                <div class='line'></div>
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
                
                $customerTemplateDB = array('ID','Name', 'Surname', 'Email', 'Address_1', 'Address_2', 'Address_3', 'Address_4', 'submit');
                $customerTemplateForm = array('id','name', 'surname', 'email', 'address1', 'address2', 'address3', 'address4', 'submit');

                //loop through template list...
                for($j = 0; $j < sizeof($customerTemplateDB); ++ $j)
                {
                    $templateDB = $customerTemplateDB[$j];
                    $template = $customerTemplateForm[$j];

                    if($template == 'submit' && !(isset($output2->result[0]->$template)))
                    {
                        //if its the last item in the list
                        echo("<script>createSumbit()</script>");
                    }
                    else
                    {
                        echo("<script>createTA('prev', 'current','" . $output2->result[0]->$templateDB . "','" . $template . "','" . $templateDB . "');</script>");
                    }
                }
            }
        } 
    ?>
</html>