<?php
/*
    transfer funds page
*/

session_start();
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";

$mainContent = "";
$cookie_val = $_COOKIE["logged-in-user"];
$hash = hash('sha256', (string)$cookie_val);

$transferForm = new SimpleForm(
    name: "Transfer Funds",
    fields: array(
        new SimpleFormField(
            type: "select",
            name: "from-account",
            accessibleName: "Sending account",
            options: array(
                "checking" => "Checking", 
                "saving" => "Saving"
            ),
            isRequired: true
        ),
        new SimpleFormField(
            type: "select",
            name: "to-account",
            accessibleName: "Receiving Account",
            defaultValue: "",
            options: array(
                "checking" => "Checking", 
                "saving" => "Saving"
            ),
            isRequired: true
        ),
        new SimpleFormField(
            type: "text",
            name: "amount",
            accessibleName: "Amount",
            isRequired: true
        ),
        new SimpleFormField(
            type: "hidden",
            name: "transId",
            defaultValue: "$hash",
            accessibleName: "transId",
            isRequired: true
        ),
    ),
    instructions: "",
    method: "POST",
    action: "/banking/transfer.php",
    submitButtonName: "Transfer Funds"
);


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

$mainContent .= $transferForm->generateHtml();
echo generatePage($mainContent);
?>
<script>
//This function gets called if the user does not have enough money in ther account
function error(){
    window.location.href = "http://localhost/banking/yo_no_money.php";
}
</script>