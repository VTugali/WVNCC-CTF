<?php
/*
    terms_accepted.php
    url tampering landing page activated when the url is changed to legal.php?accepted=1.
*/
session_start();
include "/var/www/html/include/functions.php";

$mainContent = "";
$mainContent .= createBanner("Northern <br> Phish & Loan <br> 2026", "<br> Banking for the Ohio Valley", "/img/ribbon.jpg");
$mainContent .= "<h2 style=\"margin-left:22% ; font-size:2.5rem;\" >Legal Terms have been accepted??&#129300;</h2>";
$mainContent .= "<div><h2 style=\"text-align:center;\">We are pretty sure you didn't accept our legal terms <br> and .....  you got here by url tampering &#128514; <br><br> You don't get any money &#128176; <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...   but you do capture a Flag !! &#128681;</h2></div>";
echo generatePage($mainContent);

