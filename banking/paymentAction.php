<?php
/*
    registerAction.php action page for the registration page.php webpage
    which enters the user into the database if it passes the captcha test
*/

session_start();
// These two line include the files for the functions for this page to call to be used
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";


$mainContent = "";   
$error = "";

 // This if statement checks to see if the server request from the form action is GET
 if($_SERVER['REQUEST_METHOD'] == "GET"){

    
        // These lines get the information from the user in the payments form and store the value in the 
        // $variableNames and gets the user id from the cookie of the logged in user
        $userId = $_COOKIE["logged-in-user"];
        $ss = $_GET["transId"];
        $user = userFromId((int)$userId);
        $frAcct = $_GET["fromAccount"];
        $toAcct = $_GET["toAccount"];
        $paymentAmt = $_GET["paymentAmt"];   
        
        $deposit = 0.0001;
        $transferAmt = 0;
        

    // This line calls the function to process the payment
    processPayment($ss,$userId,$frAcct, $toAcct,$paymentAmt,$deposit,$transferAmt);

}
?>