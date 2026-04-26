## Software Engineering Documentation
## Spring 2026 Charlyn Woodruff
## All files pages in this document have comments in the code of each page explaining what the code does


## our-team.php  & team_info.php webpages - in the about folder
1.	Added new profile images and information for our team members to our-team.php page.

2.	Added code to the team images in our-team.php page to make the images clickable for the user which takes them to the team_info.php page.

3.	Created and coded the team_info.php page which has a meme and a red clickable button when pressed takes the user to a funny fish video.

## legal.php webpage - in the about folder
1.	Added code the legal.php button to popup an alert window when the accept terms button is clicked, if it is clicked ok to accept terms the user is then redirected to the register.php page on the website

2.	Added code for the alert window ok button on the legal.php page, if the alert window ok button is clicked it will redirect the user to the register.php page.

## terms_accepted.php webpage - in the about folder
1. Created and coded the terms_accepted.php webpage for url tampering catch for the legal.php page, if the url is changed to legal.php?accepted=1 it will display that the user did not accept the legal terms and used url tampering to get to the webpage

## chat_support.php & chat_action.php webpages - in the about folder
1. Created and coded the chat_support.php and chat_action.php for the pop up chat box we named "Phishy". Coded error messages for sql injections and javascript usage which displays two different messages to the user where they capture a flag for discovering the cyber vulnerability. The chat bot does have an issue as it responds very slow due to being on a virtual machine using ollama, still need to fix that issue for faster responses.

2. Cyber Security team member Caleb Cunnigham coded the Ollama portion of the chat_action.php page to return and display ai responses, added the init_ollama.sh page & updated the install_mysql.sh page for curl and ollama


## pagegen.php file - in the include folder
1. Added the navigation link for the chat_support.php webpage

2. Added the navigation link for the bankTransactions.php webpage

3. Added the navigation link for the payments.php webpage


##	break-the-bank-schema.sql - in the html folder
1. Added the acctBalance table to the break-the-bank-schema.sql database page which is used by the mobile-deposit.php, transfer.php, bankTransactions.php and the bankFunctions.php pages

2.  Added the database table loanBalance which is used for the mortgage and dark vault credit account balances and the payments from the payments.php webpage


## register.php webpage & registerAction.php  coded using the POST form method due to conflicts with previous code written in the login form - in the banking folder
1.	Fixed the register.php page, added code for first name, last name to the form. Added code to connect to the database and to insert the user information from the form into the database table acctBalance.

2.	Added an error catch for the register.php page which catches if a user enters the same username, it will then display the error message gif that they are already on the list which is a hint that the user is already in the database.

3. Created and coded a new register.php page and registerAction.php to display a new registration form with a captcha. If the user gets the captcha wrong it will display a message letting them know the captcha is incorrect and after 3 tries it will display a message that they are now locked out. When the user gets the captcha correct it will then display that their account has been created and they can now login. I did use the "get" method and it worked correctly for my pages but ran into login error issues with previous code written in BTB project.

4. In the registerAction page I added code for the dark vault credit and mortgage loan accounts starting balances that call a functions that create the random start value for the mortgage loan and the Dark Vault Credit starting balances when the user registers for an account on the website. These amounts are then entered into the database table loanBalance.

5. I also added code for two different database connections and two different queries to be able to enter both the register form data into the users database table and loan & mortgage account balances and user information into the loanBalance database table.


## mobile-deposit.php webpage - in the banking folder
1. Added code to the mobile-deposit.php page to connect to the database, and the code to insert the user's deposit amount and the "to account"or $recAcct information from the mobile deposit form which then inserts the data into the database table acctBalance by userId. 2 functions that get the account balances for the checking and the savings. The if statements checks to see if the receiving account is either checking or savings, adds the deposit amount and returns the new balance to be entered into the database  table acctBalance.

2. Added new folder called "uploads" to the html directory for the check images to be uploaded from the mobile-deposit.php webpage

3. Added sprint("%.2f,$variableName) to format the checking and the savings accounts to show the decimals to 2 places.

5. Added hashed data to the mobile-deposit.php page to check for man in the middle attack which calls the funtion processMobile() from the bankingFunctions.php page which checks to see if the hashed data is the same if it is not it displays a flag page for man in the middle attack

6. Moved all main code to function sin bankingFunctions.php page

## transfer.php webpage - in the banking folder
1. Added code to the transfer.php page to connect to the database, and to insert the user's information for the account that is sending the transfer and the account receiving the funds transfer and the amount of funds being transferred from the form and then inserts the data into the database table acctBalance by userId.

2. Added code to the transfer.php page to catch if the checking or savings account balance is less than the transfer amount. If either sending account does not have enough money in the account, it will display the error page yo_no_money.php page to the user from the window location script

3. There are also functions that get the checking and saving balances which are then used to execute the transfer of funds. 

4. Added code to check if the fromAcct is NOT the same as the receiving account, if it is it will display the error message on line 77


5. Added hashed data to the transfer.php page to check for man in the middle attack which calls the funtion processTransfer() from the bankingFunctions.php page which checks to see if the hashed data is the same if it is not it displays a flag page for man in the middle attack

6. Moved all main code to function in bankingFunctions.php page

## bankTransactions.php webpage - in the banking folder
1. Created and coded the bankTransactions.php page to display pending and all completed transactions to the user using the function getTransaction($userId) in the bankFunctions.php page by the user id number 


## bankingFunctions.php page - in the banking folder
1. Created and coded the bank functions within this page to get the checking and savings balance for the logged in user, get pending and completed transactions for the logged in user to be displayed on the mobile-deposit.php, transfer.php and the bankTransactions.php pages.

2. Created functions in the bankTransaction.php page are:
    a. getCheckingBalance($userId) 
    b. getSavingsBalance($userId)
    c. getTransactions($userId)
    d. getPendingTransactions($userId)

3. Coded and added the functions generatCpatcha()and validateCaptcha() to the bankFunctions.php file, and removed the js functions from the functions.php page added them to this page.

4. Created functions in the bankTransaction.php page to get the balances of the accounts, user first name and last name,: and execute payments:
    a. getDarkStartBalance($userId)
    b. getMgStartBalance($userId)
    c. getUserName($userId)
    d. getMgBalance($userId)
    e. getDkvBalance($userId)
    f. payments($userId,$frAcct,$toAcct,$deposit $transAmt, $chkingBal, $savingBal,$mgBal,$dkvBal)

5. This payments() function uses 2 database connections and 2 different queries to insert data into the databases acctBalance and loanBalance. There are catches for balances not having enough money in the account to make a valid payment and returns the error page yo_no_money to the user and a catch for the error of trying to pay more than what is owed on an account and displays that there is an error can not process payment and to check the account balance owed. A long and complicated function to

6. Added code to display all accounts balances in the functions getPendingTransactions($userId) and function getTransactions($userId) function and updated the table content to display transfer amounts, payments, deposits, to and from accounts separately.

7. Added the sqlInjection() function for detecting sql injection for the change-password.php pageto return  the sql success page when the user succesfully enters "SELECT * FROM users" as the new password

4. Created functions in the bankTransaction.php page to check for hidden hashed data if man in the middle attack occurs on for the mobile-deposit.php, payments.php and transfer.php webpages and it will display a man in the middle message to the attacker when an attack occurs:
    a. processMobile($ss,$userId,$mobileDepositAmt,$recAcct)
    b. processPayment($ss,$userId,$frAcct, $toAcct,$paymentAmt,$deposit,$transferAmt)
    c. processTransfer($ss,$transferAmt,$toAcct,$fromAcct,$userId)
    

## payment.php & paymentAction.php webpages - Coded using the GET form method - in the banking folder
1. Coded and created the new payments.php and paymentAction.php web pages using GET. In the payments.php page I have left a script that I plan to use for referencing the window location referrer for possible tampering of the data from the GET form action.

2. In the paymentAction.php page if the server request is GET it will process the data received from the form by calling the function payments() from the bankingFunctions.php file and passing the form data values to be used in the function.
There are also 4 functions that get the account balances for the checking, savings,mortgage, and dark vault credit balances, which then are also passed in the function payments()

3. The payment page allows payments from savings and checking to the mortgage loan and the dark vault credit accounts and returns the new balances which are shown on the bankTransactions.php webpage.

4. Used Burpsuite on the payment.php and transfer.php pages, a user can intercept payments and transfers and forward new amounts to user's acccounts by changing the user id while being logged in under their own account.

5. Added hashed data to the payment.php page to check for man in the middle attack which calls the funtion processPayment() from the bankingFunctions.php page which checks to see if the hashed data is the same if it is not it displays a flag page for man in the middle attack. 

6. Moved all main code to function in bankingFunctions.php page

## change-password.php  & sqlSuccess.php webpages
1. added code the page for checking for mysql exceptions. It will display an error message to the user that the password contains sql injection. It will only display the sqlSuccess.php if the user enters "SELECT * FROM users" sql as the new password where the user receives the usernames and passwords and a flag for finding the vulnerability.

## testIframe.php webpage - is not linked to the navigation is a test page- located in the banking folder
1. Created this page with an iframe and the src is pointed at testIframe.php. it displays the entire BTB website inside the iframe and is live and functional.
