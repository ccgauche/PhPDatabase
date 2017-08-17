<?php
include "database.php";

$apikey = htmlspecialchars($_GET['apikey']);
$key = htmlspecialchars($_GET['key']);
$sheet = htmlspecialchars($_GET['sheet']);
$value = htmlspecialchars($_GET['value']);
print_r(putData($apikey,$sheet,$key,$value));
?>