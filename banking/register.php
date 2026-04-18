
<?php

/*
    register.php
    Registration page for the site.
*/

session_start();
// These two line include the files for the functions for this page to call to be used
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";
$mainContent = "";

// This is the code to create the registration form on register.php webpage
//$mainContent .= createBanner("Northern Phish & Loan ", "<br> Banking for the Ohio Valley", "/img/ribbon.jpg");
$mainContent .= "<div  style=\" margin: 5% 0 5% 38%; border: 1px solid black;background-color:#c41230; max-width:300px; role=\"presentation\"><h2 style=\"color:white;text-align:center;\">Register</h2>";
$mainContent .= "<div style=\"background-color:#f0f8ff; margin:5% 0 0 0;\" >
<p style=\"margin:15px;\">Fill the following form to create your Northern Phish &amp; Loan mobile banking account. Once completed, you will need to go to your local Northern Phish branch to complete setup.</p>
<div  style=\"background-color:#f0f8ff; max-width:300px; height:550px;\" role=\"presentation\"><form action=\"registerAction.php\" method=\"POST\" style=\"background-color:#f0f8ff; max-width:250px;margin:11%;\">

<label for=\"firstname\" style=\"margin-left: 3%; \">First Name:</label><br>
<input type=\"text\" id=\"firstname\" name=\"firstname\" style=\"margin: 1% 0 1% 3%;\" autofocus required><br>

<label for=\"lastname\" style=\"margin-left: 3%;\" >Last Name:</label><br>
<input type=\"text\" id=\"lastname\" name=\"lastname\" style=\"margin: 1% 0 1% 3%;\" required><br>

<label for=\"email\" style=\" margin-left: 3%;\">Email:</label><br>
<input type=\"email\" id=\"email\" name=\"email\" style=\"margin: 1% 0 1% 3%;\" required><br>

<label for=\"username\" style=\"margin-left: 3%;\">Username:</label><br>
<input type=\"text\" id=\"username\" name=\"username\" style=\"margin: 1% 0 1% 3%;\" required><br>

<label for=\"password\" style=\"margin-left:10px;\">Password:</label><br>
<input type=\"password\" id=\"password\" name=\"password\" style=\"margin: 1% 0 1% 3%;\" required><br>

<label for=\"retypePswd\" style=\"margin-bottom:10px;margin-left:15px;\">Retype Password:</label>
<input type=\"password\" id=\"retpyePswd\" name=\"retypePswd\" style=\"margin: 1% 0 1% 3%;\" required><br><br>";

// This is the code to create the canvas captcha for the captcha in the registration form 
// and the two buttons call the generatCaptcha() and validateCaptcha() functions from the functions.php file
// when the buttons are clicked to generate and validate the captcha code
$mainContent .= "<canvas id=\"captchaCanvas\" width=\"200\" height=\"50\" style=\"border:1px solid #0e0d0d; margin-left:5%; margin-bottom:10px;\"></canvas>
<br><input type=\"text\" style=\"margin:4%;max-width:200px;\" id=\"userInput\" name=\"captcha\" placeholder=\"Enter Captcha\" required >
<br><button style=\"margin-left:5%; margin-bottom:10px;margin-right:8px;\" onclick=\"generateCaptcha()\">Refresh</button>
<button type=\"submit\" id=\"btn\" onclick=\"validateCaptcha()\"> Register</button><br>
<h4 id=\"message\" style=\"margin-left:20px;\"> </h4></form></div></div>";

// This line displays the content on the webpage by calling the function generatePage()
echo generatePage($mainContent);
?>


// This script calls the generateCaptcha function from the 
// functions.php file to load  and display the captcha when the register.php window loads
<script>
window.onload = generateCaptcha;
</script>