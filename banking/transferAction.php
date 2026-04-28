<?php

session_start();
// These two line include the files for the functions for this page to call to be used
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";


if($_SERVER['REQUEST_METHOD'] == "POST") {

     // These lines get the information from the user in the tranfer form and store the value in the $variableNames
    $transferAmt = $_POST['amount'];
    $toAcct = $_POST['to-account'];
    $fromAcct = $_POST['from-account'];
   
    //These two lines get the user id from the cookie of the logged in user
    $userId = $_COOKIE["logged-in-user"];
    $user = userFromId((int)$userId);
    $ss = $_POST['transId'];

    // This line calls the function to process the transfer
    processTransfer($ss,$transferAmt,$toAcct,$fromAcct,$userId);
 
}

?>
<script>
//This function gets called if the user does not have enough money in ther account
function error(){
    window.location.href = "http://localhost/banking/yo_no_money.php";
}
</script>