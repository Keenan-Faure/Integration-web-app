<?php
if(isset($_POST['checkConnection']))
{
    echo("Checking connection...");
    unset($_POST['checkConnection']);
}
if(isset($_POST['viewLog']))
{
    echo("Displaying log");
    unset($_POST['viewLog']);
}
if(isset($_POST['visitS2S']))
{
    echo("redirecting in 2seconds...");
    unset($_POST['visitS2S']);
}
if(isset($_POST['getProductBySKU']) && $_POST['getProductBySKU'])
{
    echo("Searching for SKU " . $_POST['getProductBySKU']);
    unset($_POST['getProductBySKU']);
}
if(isset($_POST['getProductsBatch']))
{
    echo("getting product batch");
    unset($_POST['getProductsBatch']);
}
if(isset($_POST['countProduct']))
{
    echo("counting products");
    unset($_POST['countProduct']);
}
if(isset($_POST['viewProductSql']))
{
    echo("view product sql");
    unset($_POST['viewProductSql']);
}
if(isset($_POST['addProduct']))
{
    echo("adding product ");
    unset($_POST['addProduct']);
}
if(isset($_POST['getCustomerByName']))
{
    echo("getCustomerby name");
    unset($_POST['getCustomerByName']);
}
if(isset($_POST['countCustomer']))
{
    echo("count customers");
    unset($_POST['countCustomer']);
}
if(isset($_POST['viewCustomerSql']))
{
    echo("view customer sql");
    unset($_POST['viewCustomerSql']);
}
if(isset($_POST['addCustomer']))
{
    echo("add a customer to the database");
    unset($_POST['addCustomer']);
}

?>