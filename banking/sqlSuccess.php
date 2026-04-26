<?php

/*
   sql Success page for the sql injection from the change-password.php page
*/

session_start();
// These two line include the files for the functions for this page to call to be used
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";


$mainContent = "";

// This line sets the mainConent to the function sqlInjection() 
$mainContent .= sqlInjection();

// This line displays the content on the webpage by calling the function generatePage() with the main content html
echo generatePage($mainContent);
?>
