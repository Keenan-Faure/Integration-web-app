
<?php
session_start();
print_r($_POST);
echo(json_encode($_SESSION['log']));
?>