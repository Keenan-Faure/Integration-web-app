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
if(isset($_POST['getProductBySKU']))
{
    print_r($_POST['getProductBySKU']);
    echo("Searching for SKU " . $_POST['getProductBySKU']);
    unset($_POST['getProductBySKU']);
}
if(isset($_POST['getProductsBatch']))
{
    echo("yes indeed");
    unset($_POST['getProductsBatch']);
}
if(isset($_POST['countProduct']))
{
    echo("yes indeed");
    unset($_POST['countProduct']);
}
if(isset($_POST['viewProductSql']))
{
    echo("yes view product sql");
    unset($_POST['viewProductSql']);
}
if(isset($_POST['addProduct']))
{
    echo("yes indeed");
    unset($_POST['addProduct']);
}
if(isset($_POST['getCustomerByName']))
{
    echo("yes indeed");
    unset($_POST['getCustomerByName']);
}
if(isset($_POST['countCustomer']))
{
    echo("yes indeed");
    unset($_POST['countCustomer']);
}
if(isset($_POST['viewCustomerSql']))
{
    echo("yes indeed");
    unset($_POST['viewCustomerSql']);
}
if(isset($_POST['addCustomer']))
{
    echo("yes indeed");
    unset($_POST['addCustomer']);
}

?>