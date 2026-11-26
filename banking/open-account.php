<?php
/*
    open-account.php
    POST endpoint for opening of new bank accounts. Associated form is on the dashboard.
*/
session_start();
include "/var/www/html/include/functions.php";
$errorMessage = "";
$user = getCurrentUser();

if(!$user) {
    // Not logged in? Go away!
    header("Location: /banking/login.php");
    exit();
}

// This if statement checks to see if the session attempts are not set and sets it to 0
if(!isset($_SESSION['attempts'])){
    $_SESSION['attempts'] = 0;
}

// This checks to see if the request method is POST, then checks to see if the session attempts
// for opening an account is greater than 6 and will return the user to the dashboard and not create
// any more new accounts
if($_SERVER['REQUEST_METHOD'] == "POST") {
 
    if($_SESSION['attempts'] > 6){
        header("Location: /banking/dashboard.php");
        die();
    }
    // This is the counter for the session attempts for the dashboard open account page
    $_SESSION["attempts"]++;


    $userId = $_COOKIE["logged-in-user"];

    // This variable is set to and calls the function getAcctType() by the user id from the functions.php
    // page to get the account type which limits the user to be able create only
    //  one account type of each on the dashboard.php page
    $acctType = getAccType($userId);

    // This if statement checks to see if the account type from the 
    // database of the user equals the input from the open account won the dashboard.php 
    // page and will display an error  below letting the user know they can only open one account
    // of each type
    if($acctType == $_POST["account-type"]){
        $mainContent = "";
        $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
        $mainContent .= "<h2 style=\"margin:auto;\">Thanks for choosing Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;margin-left: 10px;\"><br>An error has occurred, as you can only open one account of each type.</p></div>";
        echo generatePage($mainContent);
        exit();
    } 
    
    if(!isset($_POST["account-type"]) || !isset($_POST["account-nickname"])) {
        // User somehow bypassed the client-side verification, should never happen
        $errorMessage = "<h2>Could Not Open Account</h2>";
        $errorMessage .= "<p class=\"error-block\">We were unable to open your account because of a technical problem on our end. We apologize for the inconvience and will work to fix the problem shortly.</p>";
        $errorMessage .= "<p>[400 Error: required POST parameters not set]</p>";
        http_response_code(400);
        echo generatePage(singleColumnLayout($errorMessage));
        exit();
    }
   // this functions inserts the new account into the database for the logged in user
    insertAccountIntoDb(new BankAccount(0, $user->userId, AccountType::fromString($_POST["account-type"]), $_POST["account-nickname"]));

} else {
    header("Location: /banking/dashboard.php");
}
header("Location: /banking/dashboard.php");