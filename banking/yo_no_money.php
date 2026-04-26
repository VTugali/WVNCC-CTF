<?php
/*
    yo_no_money.php error page when bank customer tries to 
    transfer more money than they have in their account
   displays this error message and funny gif character
*/
session_start();
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";

$mainContent = "";
$mainContent .= "<div class=\"single-column\" role=\"presentation\">";
$mainContent .= "<h2 style=\"margin-bottom:0;\">Thanks for choosing Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> We can not process your transaction, not enough funds in your account!! Deposit some money fool!!</p></div>";
$mainContent .= "<div style=\"margin-left:25%; margin-bottom:10%;\"><img src=\"/img/broke.jpg\" width=\"500px\"; height=\"500px\";></div>"; 
echo generatePage($mainContent);
