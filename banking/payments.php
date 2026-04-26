<?php

/*
    payments.php
    Payments page for the site.
*/

session_start();
// These two line include the files for the functions for this page to call to be used
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";
 

// These lines are the code to create the payments form on payments.php webpage
$mainContent = "";
$info = "";
$error ="";
$cookie_val = $_COOKIE["logged-in-user"];
$hash = hash('sha256', (string)$cookie_val);

$mainContent .= "<div  style=\" margin: 5% 0 5% 38%; border: 1px solid black;background-color:#c41230; max-width:300px; role=\"presentation\"><h2 style=\"color:white;text-align:center;\">Payments</h2>";
$mainContent .= "<div style=\"background-color:#f0f8ff; margin:5% 0 0 0;\" >
<p style=\"margin:15px;\">Fill the following form to submit your Northern Phish &amp; Loan payment for your Morgage or Dark Vault Credit accounts.</p>
<div  style=\"background-color:#f0f8ff; max-width:300px; height:320px;\" role=\"presentation\"><form action=\"paymentAction.php\" method=\"GET\" id=\"payment\" style=\"background-color:#f0f8ff; max-width:250px;margin:11%;\">
<div style=\"margin: 3%;\"> <input type=\"hidden\" name=\"transId\" value=\"$hash\"><label for=\"from-account\" >Sending Account:</label>
<br><select id=\"fromAccount\" name=\"fromAccount\" style=\"margin:2% 0;\">
<option value=\"  \">-- Select Account --</option><option value=\"checking\">Checking</option>
<option value=\"saving\">Savings</option></select><br><br>
<label for=\"toAccount\">Receiving Account:</label>
<select id=\"toAccount\" name=\"toAccount\" style=\"margin:2% 0;\"> 
<option value=\" \"> -- Select Account -- </option><option value=\"morgage\">Morgage</option>
<option value=\"DVCredit\">Dark Vault Credit</option></select><br><br>
<label for=\"paymentAmt\">Payment Amount:</label><input type=\"text\" id=\"paymentAmt\" name=\"paymentAmt\"  style=\"margin:1%;\" required></div><br>
<button type=\"submit\" id=\"btn\" onclick=\"showAlert()\" style=\"margin-left:30%;\" >Submit</button><br><h4 id=\"message\" style=\"margin-left:20px;\"></h4></form></div></div>";


// This line displays the content on the webpage by calling the function generatePage()
echo generatePage($mainContent);

?>