<?php

/*
   Test Iframe page
*/

session_start();
// These two line include the files for the functions for this page to call to be used
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";


$mainContent = "";

$mainContent .= "<div style=\"background-color:#f0f8ff; margin:5% 0 0 0;\" >
<p style=\"margin:15px;\">Embedded iframe Northern Phish &amp; Loan <br>Congrats! You have discovered our hidden fully functional website inside an iframe! <br> You receive a &#128681 for your hacking efforts </p>
<iframe style=\"background-color:transparent;border:non; margin:5% 0 5% 5%;width:90%; height:85%;\" src=\"testIframe.php\">
</iframe></div>";

// This line displays the content on the webpage by calling the function generatePage()
echo generatePage($mainContent);
?>
