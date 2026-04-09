## Software Engineering Documentation
## Spring 2026 Charlyn Woodruff
## All files pages in this document have comments in the code of each page explaining what the code does

## our-team.php  & team_info.php webpages
1.	Added new profile images and information for our team members to our-team.php page.
2.	Added code to the team images in our-team.php page to make the images clickable for the user which takes them to the team_info.php page.
3.	Created and coded the team_info.php page which has a meme and a red clickable button when pressed takes the user to a funny fish video.

## legal.php webpage
1.	Added code the legal.php button to popup an alert window when the accept terms button is clicked, if it is clicked ok to accept terms the user is then redirected to the register.php page on the website
2.	Added code for the alert window ok button on the legal.php page, if the alert window ok button is clicked it will redirect the user to the register.php page.

## terms_accepted.php webpage
1. Created and coded the terms_accepted.php webpage for url tampering catch for the legal.php page, if the url is changed to legal.php?accepted=1 it will display that the user did not accept the legal terms and used url tampering to get to the webpage

## chat_support.php & chat_action.php 
1. Created and coded the chat_support.php and chat_action.php for the pop up chat box we named "Phishy". Coded error messages for sql injections and javascript usage which displays two different messages to the user where they capture a flag for discovering the cyber vulnerability. The chat bot does have an issue as it responds very slow due to being on a virtual machine using ollama, still need to fix that issue for faster responses.
2. Cyber Security team member Caleb Cunnigham coded the Ollama portion of the chat_action.php page to return and display ai responses, added the init_ollama.sh page & updated the install_mysql.sh page for curl and ollama

##	break-the-bank-schema.sql
1. Added the acctBalance table to the break-the-bank-schema.sql database page which is used by the mobile-deposit.php, transfer.php, bankTransactions.php and the bankFunctions.php pages

## register.php webpage 
1.	Fixed the register.php page, added code for first name, last name to the form. Added code to connect to the database and to insert the user information from the form into the database table acctBalance.
2.	Added an error catch for the register.php page which catches if a user enters the same username, it will then display the error message gif that they are already on the list which is a hint that the user is already in the database.

## mobile-deposit.php webpage
## Added new folder called "uploads" to the html directory for the check images to be uploaded from the mobile-deposit.php webpage
1. Added code to the mobile-deposit.php page to connect to the database, and the code to insert the user's deposit amount and the "to account" information from the mobile deposit form which then inserts the data into the database table acctBalance by userId.

## transfer.php webpage
1. Added code to the transfer.php page to connect to the database, and to insert the user's information for the account that is sending the transfer and the account receiving the funds transfer and the amount of funds being transferred from the form and then inserts the data into the database table acctBalance by userId.
2. Added code to the transfer.php page to catch if the transfer amount is more than what is in the account they choose as the sending account. If either sending account does not have enough money in the account, it will display the error page yo_no_money.php page to the user

## bankTransactions.php webpage
1. Created and coded the bankTransactions.php page to display pending and all completed transactions to the user using the function getTransaction($userId) in the bankFunctions.php page by the user id number 

## bankFunctions.php page
1. Created and coded the bank functions within this page to get the checking and savings balance for the logged in user, get pending and completed transactions for the logged in user to be displayed on the mobile-deposit.php, transfer.php and the bankTransactions.php pages.
2. Created functions in the bankTransaction.php page are :
    a. getCheckingBalance($userId) 
    b. getSavingsBalance($userId)
    c. getTransactions($userId)
    d. getPendingTransactions($userId)