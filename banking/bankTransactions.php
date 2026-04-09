<?php
/*
    bankTransaction.php page that lists all bank transactions for the logged in user accounts .
*/

session_start();

// These two line include the files for the functions for this page to call to be used
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";

// These 3 lines get the user Id number from the cookie of the logged in user
// and stores it in the variable $userId and gets all transactions by calling 
// the getTransactions function in the bankFunctions.php page
$userId = $_COOKIE["logged-in-user"];
$user = userFromId((int)$userId);
getTransactions($userId);