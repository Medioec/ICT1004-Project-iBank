<?php 
session_start();
if(!isset($_SESSION["customerId"])) include "indexDefault.php";
else include "indexLoggedIn.php";
?>
