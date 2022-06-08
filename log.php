
<?php
session_start();
header('Content-Type: application/json');
$variable = new \stdClass();
for($i = sizeof($_SESSION['log']) -1 ; $i > -1; --$i)
{
    $index = $i + 1;
    print_r('');
    $variable->$index = $_SESSION['log'][$i];
}
echo(json_encode($variable));
?>