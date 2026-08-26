<?php
/*
    transfer funds page
*/

session_start();
include "/var/www/html/include/functions.php";
include_once "/var/www/html/banking/bankingFunctions.php";

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
    action: "/banking/transferAction.php",
    submitButtonName: "Transfer Funds"
);

$mainContent .= $transferForm->generateHtml();
echo generatePage($mainContent);
?>