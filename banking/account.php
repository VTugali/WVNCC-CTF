<?php
/*
    daskboard.php
    Page for users to manage their finances. 
*/
session_start();
include "/var/www/html/include/functions.php";
include_once "/var/www/html/banking/bankingFunctions.php";
include_once "/var/www/html/include/bankaccount.php";

$userId = $_COOKIE["logged-in-user"];

$mainContent = "";
if(isLoggedIn()) {
    $leftColumn = "";
    $rightColumn = "";
    $account = bankAccountFromAccountNumber($_GET["account-number"]);
    $number = $account->accountNumber;
    $type = $account->accountType->toString();
  
    $mainContent = "";
    $mainContent = "<div class=\"banner\" style=\"background-color:#c41230; color:white; height: 300px;\">";
    $mainContent .= generateAccountCard($account, 0, False);
    $mainContent .= "</div>";
    $mainContent .= "<a href=\"accountInfo.php\"><button style=\"margin-left:10px\" aria-expanded=\"false\" >Account options</button></a>";
    $mainContent .= "<p style=\"margin-left:10px\" >Recent transactions</p>";

    // This line displays  html for the separate transactions for the dashboard accounts by 
    // calling the getSepTransactions() function by user id and account type
    $mainContent .= getSepTransactions($userId, $type);
    $mainContent .= "</tbody>";
    $mainContent .= "</table>";
   
    echo generatePage($mainContent);
}

