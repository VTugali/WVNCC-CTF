<?php
/*
   Customer Information page
   accounInfo.php page
*/
session_start();
include "/var/www/html/include/functions.php";

$mainContent = "";
$userId = $_COOKIE["logged-in-user"];
if(isLoggedIn()) {
  
    $mainContent = "";
    $mainContent = "<div class=\"banner\" style=\"background-color:#c41230; color:white; height: 300px;\">";
    $name =  getUserName($userId);

    // This area needs finished and try to implement a cyber security flaw to be found, the only
    // link is from the account page from the button "Account Options"
    $mainContent .= "<h2 style=\"float: right;margin-right:100px;\"> Customer Information</h2><h2 style=\"margin:0px 100px 25px 100px\";<br><br>Name: $name <br> Address:<br>Phone: <br> Email: <br> Security Pin: <br> </h2></div>";
    $mainContent .= "<h2 style=\"margin:25px 100px 25px 100px\"> Accounts</h2><h3 style=\"margin:25px 100px 25px 100px\"><br> Checking Account Number: <br> Saving Account Number:<br> Morgage Account Number: <br> Dark Vault Credit Account Number:<h3>";
echo generatePage($mainContent);
}