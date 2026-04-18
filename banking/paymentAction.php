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

    // This if statement checks to see if the selection from the options in the form is not selected and 
    // the user did not make a selection of the to or from accounts and displays the error message 
    // below to the user
    if (!isset($_GET["toAccount"]) || !isset($_GET["fromAccount"])){
        $error = "<h2>Could Not Complete the transaction</h2>";
        $error .= "<p class=\"error-block\">We were unable to complete your transaction. Please make sure the payment form is filled out completely. We apologize for the inconvience and will work to fix the problem shortly.</p>";
        $error .= "<p>[400 Error: required GET parameters not set]</p>";
        http_response_code(400);
        echo generatePage(singleColumnLayout($error));
        exit();
    } 
        // These lines get the information from the user in the payments form and store the value in the 
        // $variableNames and gets the user id from the cookie of the logged in user
        $userId = $_COOKIE["logged-in-user"];
        $user = userFromId((int)$userId);
        $frAcct = $_GET['fromAccount'];
        $toAcct = $_GET['toAccount'];
        $paymentAmt = $_GET["paymentAmt"];   

        $deposit = 0.0001;
        $transferAmt = 0;


        // These lines set the variable names to the functions to get the checking,savings, morgage and
        // darkvault cedit account balances
        $chkingBal = getCheckingBalance($userId);
        $savingBal = getSavingsBalance($userId);
        $mgBal = getMgBalance($userId);
        $dkvBal = getDkvBalance($userId);
        

payments($userId,$frAcct, $toAcct,$paymentAmt,$deposit,$transferAmt,$chkingBal, $savingBal,$mgBal,$dkvBal);
 }