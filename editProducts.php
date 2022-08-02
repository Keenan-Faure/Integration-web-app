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
                <h1>Edit Product</h1>
                <div class='line'></div>
            </div>
            <div class='containers' id='main'>
                <textarea id = 'smaller' class='typeE'>Product Attribute</textarea>
                <textarea id = 'smaller' class='prev'>Current Value</textarea>
                <textarea id = 'smaller' class='current'>Editable Value</textarea>
                <form id='form' action='processEdit.php' method='post'></form>
            </div>
        </div>

    </body>
    <script src='Scripts/createElements.js'></script>
    <?php 
        if(isset($_SESSION['products']))
        {
            $sku = array_keys($_POST)[0];
            unset($_POST);
            if($_SESSION['connection'])
            {
                $connection2 = new connect();
                $rawConnection = $connection2->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query2 = 'select * from Inventory where SKU = "' . $sku .  '"';
                $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);

                $_SESSION['edit_prod'] = new \stdClass();

                $productTemplateDB = array('Title', 'Description', 'Category', 'Product_Type', 'Brand', 'SKU', 'Group_Code', 'Variant_Code', 'Barcode', 'Weight', 'CostPrice', 'SellingPrice',
                                        'CapeTown_Warehouse', 'Option_1_Name', 'Option_1_Value', 'Option_2_Name', 'Option_2_Value', 'Meta_1', 'Meta_2', 'Meta_3', 'submit');

                $productTemplateForm = array('title', 'description', 'category', 'productType', 'brand', 'sku', 'groupingCode', 'variantCode', 'barcode', 'weight', 'costPrice', 'sellingPrice',
                'quantity', 'optionName', 'optionValue', 'option2Name', 'option2Value', 'meta1', 'meta2', 'meta3', 'submit');
                //loop through template list...
                
                for($j = 0; $j < sizeof($productTemplateDB); ++ $j)
                {                    
                    $templateDB = $productTemplateDB[$j];
                    $template = $productTemplateForm[$j];

                    if($templateDB == 'submit' && !(isset($output2->result[0]->$templateDB)))
                    {
                        echo("<script>createSumbit()</script>");
                    }
                    else
                    {
                        if(isset($output2->result[0]->$templateDB) && $output2->result[0]->$templateDB != null)
                        {
                            if($templateDB == 'Description')
                            {
                                //decodes it
                                $var = htmlspecialchars_decode($output2->result[0]->$templateDB);

                                //fixes the html
                                $var = str_replace(["\r\n", "\r", "\n"], '', $var);
                                $_SESSION['edit_prod']->$template = $var;
                                echo("<script>createTA('prev', 'current','" . $var . "','" . $template . "','" . $templateDB . "');</script>");
                            }
                            else
                            {
                                //if its the last item in the list
                                $_SESSION['edit_prod']->$template = $output2->result[0]->$templateDB;
                                echo("<script>createTA('prev', 'current','" . $output2->result[0]->$templateDB . "','" . $template . "','" . $templateDB . "');</script>");
                            }
                        }
                        else
                        {
                            $var = 'null';
                            $_SESSION['edit_prod']->$template = $output2->result[0]->$templateDB;
                            echo("<script>createTA('prevNA', 'currentNA','" . $var . "','" . $template . "','" . $templateDB . "');</script>");
                        }
                    }
                }
            }
        } 
    ?>
</html>