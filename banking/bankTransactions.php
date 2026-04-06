<?php
/*
    bankTransaction.php page that lists all bank transactions for the logged in user accounts .
*/

session_start();
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";

$userId = $_COOKIE["logged-in-user"];
$user = userFromId((int)$userId);
getTransactions($userId);