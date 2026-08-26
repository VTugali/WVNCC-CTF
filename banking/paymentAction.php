<?php
/*
    paymentAction.php action page for the payment webpage
  
*/

session_start();
// These two line include the files for the functions for this page to call to be used
include_once "/var/www/html/include/functions.php";
include_once "/var/www/html/banking/bankingFunctions.php";


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

    // This line calls the function to process the payment for the morgage or the dark vault credit
    processPayment($ss,$userId,$frAcct, $toAcct,$paymentAmt,$deposit,$transferAmt);
   
}
?>