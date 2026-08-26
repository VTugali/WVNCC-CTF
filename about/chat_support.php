<?php
/*
    Chat Bot support page.php
    
*/

session_start();
include "/var/www/html/include/functions.php";

$mainContent = "";
$mainContent .= createBanner("Northern <br> Phish & Loan <br> 2026", "<br> Banking for the Ohio Valley", "/img/search-banner.jpg");
$mainContent .= "<h1 style=\"margin:5% 0 1% 15%;\"> Welcome to our ChatBot Phishy &#128032;</h1>";
$mainContent .= "<p style=\"margin-left:15%; font-size:larger; \">Feel free to ask Phishy anything you like, he enjoys swimming around <br> the website causing mischief everywhere he goes !<br> But whatever you do, DO NOT tell Phishy what to do! &#128521</p>";

// ChatBot message box code
$mainContent .= " <button style=\"  background-color: #555; color: white; padding: 16px 20px;
  border: none; cursor: pointer; opacity: 0.8; position: absolute; bottom: 0px; right: 50px;
  width: 250px;\" onclick=\"openForm()\"> Chat</button> <div id=\"myChat\" style=\"display: none;
  position: absolute; bottom: -15px; right: 25px; border: 3px solid #055c1f; z-index: 9;\" > 
  <form action=\"/about/chat_action.php\" method=\"post\" style=\" max-width: 300px; padding: 10px;
  background-color: white;\"><h1>Chat</h1> <label for=\"msg\"><b>Message</b></label><label style=\"font-size:50px;float:right;\">&emsp;&emsp;&#128032;</label> <textarea style=\"  width: 25%;
  padding: 15px; width:100%; margin: 5px 0 22px 0; border: 1px solid black; background: #f1f1f1; resize: none;
  min-height: 200px; \" placeholder=\"Type message..\" name=\"msg\" id=\"msg\" required></textarea><button type=\"submit\" style=\"  background-color: #047048;
  color: white; padding: 16px 20px; border: none; cursor: pointer; width: 100%; margin-bottom:20px;
  opacity: 0.9;\" >Send</button><button type=\"button\" style=\"background-color: #c41230;width:100%;\" onclick=\"closeForm()\">Close</button></form></div>";

  // This line displays the chat box on the webpage
echo generatePage($mainContent);
?>
<script>
  /*
    This function is activated when the gray button on the chat Box support page and action page is 
    clicked and opens the chat box
*/ 
function openForm() {
  document.getElementById("myChat").style.display = "block";
}
/*
    This function is activated when the red close button on the chat Box support page and action page is 
    clicked and closes / hides the chat box
*/ 
function closeForm() {
  document.getElementById("myChat").style.display = "none";
}

</script>