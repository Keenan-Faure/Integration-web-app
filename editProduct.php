<?php session_start(); ?>
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
            <div class='containers' id='main'></div>
        </div>

    </body>
    <script src='Scripts/createElements.js'></script>
    <?php 
        if(isset($_SESSION['products']))
        {
            $productTemplateDB = array('Title', 'Description', 'Category', 'Product_Type', 'Brand', 'SKU', 'Grouping_Code', 'Variant_Code', 'Barcode', 'Weight', 'CostPrice', 'SellingPrice',
                                    'CapeTown_Warehouse', 'Option_1_Name', 'Option_1_Value', 'Option_2_Name', 'Option_2_Value', 'Meta_1', 'Meta_2', 'Meta_3');

            for($i = 0; $i < sizeof($_SESSION['products']->result); ++ $i)
            {
                //loop through template list...
                for($j = 0; $j < sizeof($productTemplateDB); ++ $j)
                {
                    $template = $productTemplateDB[$j];
                    echo("<script>createTA('prev', 'current','" . $_SESSION['products']->result[0]->$template . "', 'title');</script>");
                }
            }
        } 
    ?>
</html>