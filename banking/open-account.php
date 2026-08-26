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
// for opening an account is greater than or = to 4 limiting the accounts a user can open to 4 if they try
// to open a 5th account it will just return them to the dashboard
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if($_SESSION['attempts'] >= 4){
        header("Location: /banking/dashboard.php");
        die();
    }
    // This is the counter for the session attempts for the dashboard open account page
    $_SESSION["attempts"]++;

    if(!isset($_POST["account-type"]) || !isset($_POST["account-nickname"])) {
        // User somehow bypassed the client-side verification, should never happen
        $errorMessage = "<h2>Could Not Open Account</h2>";
        $errorMessage .= "<p class=\"error-block\">We were unable to open your account because of a technical problem on our end. We apologize for the inconvience and will work to fix the problem shortly.</p>";
        $errorMessage .= "<p>[400 Error: required POST parameters not set]</p>";
        http_response_code(400);
        echo generatePage(singleColumnLayout($errorMessage));
        exit();
    }

    insertAccountIntoDb(new BankAccount(0, $user->userId, AccountType::fromString($_POST["account-type"]), $_POST["account-nickname"]));

} else {
    header("Location: /banking/dashboard.php");
}
header("Location: /banking/dashboard.php");