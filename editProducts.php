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
            </div>
        </div>

    </body>
    <script src='Scripts/createElements.js'></script>
    <?php 
        if(isset($_SESSION['products']))
        {
            $sku = array_keys($_POST)[0];
            if($_SESSION['connection'])
            {
                $connection2 = new connect();
                $rawConnection = $connection2->createConnection($_SESSION['credentials']->username, $_SESSION['credentials']->password, 'localhost', $_SESSION['connection']->credentials->dbname)->rawValue;
                $query2 = 'select * from Inventory where SKU = "' . $sku .  '"';
                $output2 = $connection2->converterObject($rawConnection, $query2, $_SESSION['connection']->credentials->dbname);

                $productTemplateDB = array('Title', 'Description', 'Category', 'Product_Type', 'Brand', 'SKU', 'Grouping_Code', 'Variant_Code', 'Barcode', 'Weight', 'CostPrice', 'SellingPrice',
                                        'CapeTown_Warehouse', 'Option_1_Name', 'Option_1_Value', 'Option_2_Name', 'Option_2_Value', 'Meta_1', 'Meta_2', 'Meta_3');

                //loop through template list...
                for($j = 0; $j < sizeof($productTemplateDB); ++ $j)
                {
                    
                    $template = $productTemplateDB[$j];
                    
                    if(isset($output2->result[0]->$template))
                    {
                        if($template == 'Description')
                        {
                            //decodes it
                            $var = htmlspecialchars_decode($output2->result[0]->$template);

                            //fixes the html
                            $var = str_replace(["\r\n", "\r", "\n"], '', $var);
                            echo("<script>createTA('prev', 'current','" . $var . "','" . $template . "');</script>");
                        }
                        else
                        {
                            echo("<script>createTA('prev', 'current','" . $output2->result[0]->$template . "','" . $template . "');</script>");
                        }
                    }
                }
            }
        } 
    ?>
</html>