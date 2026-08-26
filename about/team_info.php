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
$mainContent .= createBanner("Northern Phish & Loan <br> Fun Facts about our Team", "<br> Banking for the Ohio Valley", "/img/bank.webp");
$mainContent .= "<h1 style=\"margin:15px;\"> Northern Phish & Loan Team Information</h1>";
$mainContent .= "<div style=\"margin-left:20%;padding:1%;\"><button type=\"button\" style=\"background-color:transparent;color:black; \" onclick=\"funnyVideo()\">Click Here !!<br><img src=\"/img/redButton.webp\" width=\"95px\"; height=\"95px\";></button><img src=\"/img/dee_dee_meme.webp\" style=\"max-wdith:300px; max-height:300px; margin-left:8%; display:inline;\"></div>";
echo generatePage($mainContent);

?>
<script>
  /*
    This function is activated when the large red button on the team_info.php page is clicked and
    redirects the user to a funny fish video on youtube. 
*/   
function funnyVideo(){
    window.location = "https://www.youtube.com/watch?v=mHJ3l18YqNM_popup?autoplay=1&mode=theater";
    } 
</script>  