<?php
/*
    team_info.php
    Finished team profile pics and information page, implemented clickable profile pictures, 
    to this landing page with a large red button on the team_info.php page which redirects to funny fish
    video when the button is clicked which is activated by the javascript function funnyVideo() 
    in the functions.php file
    .
*/
session_start();
include "/var/www/html/include/functions.php";

$mainContent = "";
$mainContent .= createBanner("Northern Phish & Loan <br> Fun Facts about our Team", "<br> Banking for the Ohio Valley", "/img/ribbon.jpg");
$mainContent .= "<h1 id=\"test\"> Northern Phish & Loan Team Information</h1>";
$mainContent .= "<div style=\"margin-left:20%;padding:1%;\"><input type=\"button\" style=\"background-color:red; hover:padding:10px; width:120px; height:120px;margin-bottom:30px; border-radius:50%; font-weight:bold; font-size:1.3em; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.6); color:white;\"  onclick=\"funnyVideo()\" value=\"Click \nhere! \"><img src=\"/img/dee_dee_meme.webp\" style=\"max-wdith:300px; max-height:300px; margin-left:5%; display:inline;\"></div>";
echo generatePage($mainContent);
