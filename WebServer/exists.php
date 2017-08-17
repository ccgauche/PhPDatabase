<?php
include "database.php";

$apikey = htmlspecialchars($_GET['apikey']);
$key = htmlspecialchars($_GET['key']);
$sheet = htmlspecialchars($_GET['sheet']);
print_r(existsData($apikey,$sheet,$key));
?>