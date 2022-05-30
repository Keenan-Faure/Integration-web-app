
<?php
session_start();
$variable = new \stdClass();
for($i = 0; $i < sizeof($_SESSION['log']); ++$i)
{
    $index = $i + 1;
    $variable->$index = $_SESSION['log'][$i];
}
echo(json_encode($variable));
?>