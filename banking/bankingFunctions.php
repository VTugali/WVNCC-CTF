<?php 
  /*
    Banking functions page
*/

 // Function to get the Checking account balance from the database for the user by user ID
function getCheckingBalance($userId){

    // This line sets the variable $database to the connectToDatabase function
    $database = connectToDataBase();

    // These three lines set the query to get the information from the acctBalance table in the database
    // by the user id number
    $query = "SELECT * FROM acctBalance WHERE userId = $userId";
    $result = mysqli_query($database,$query);
    $chkingBal = 0;

    // This if statment checks to see if there is any result in the database
    if(mysqli_num_rows($result) > 0){

        // Then this while statement loops through the data in the database and returns the data
        // and stores it in the varaible $schkngBal and returns that value
        while($row = mysqli_fetch_assoc($result)){
            $chkingBal = $row['checkingBalance'];
        } 
    }  
    // Checkings account balance amount returned
    return ($chkingBal) ;       
}


// Function to get the Savings account balance from the database for the user by user ID
function getSavingsBalance($userId){

    // This line sets the variable $database to the connectToDatabase function
    $database = connectToDataBase();

    // These three lines set the query to get the information from the acctBalance table in the database
    // by the user id number
    $query = "SELECT * FROM acctBalance WHERE userId = $userId";
    $result = mysqli_query($database,$query);
    $savingBal = 0;

    // This if statment checks to see if there is any result in the database
    if(mysqli_num_rows($result) > 0){

    // Then this while statement loops through the data in the database and returns the data
    // and stores it in the varaible $savingBal and returns that value
        while($row = mysqli_fetch_assoc($result)){
            $savingBal = $row['savingsBalance'];
        } 
    }  
    // Savings account balance amount returned
    return ($savingBal) ;  
}


// Function to get the transactions from the database for the user by user ID
function getTransactions($userId){

    // This line sets the variable $database to the connectToDatabase function
    $database = connectToDataBase();

    // These two lines set the query to get the information from the acctBalance table in the database
    // by the user id number
    $query = "SELECT * FROM acctBalance WHERE userId = $userId ORDER BY transactionId DESC LIMIT 10 ";
    $result = mysqli_query($database,$query);
    
    $mainContent = "";
    
    // Thses two lines set the variables to the functions to get the checking and savings account balances
    $currentSavBal = getSavingsBalance($userId);
    $currentchkBal = getCheckingBalance($userId);
    
    // This if statment checks to see if there is any result in the database    
    if(mysqli_num_rows($result) > 0){
        $mainContent .= "<h2 style=\"margin-left:10%;margin-top:5%;\">Bank Transaction Information</h2> ";
        $mainContent .= "<h3 style=\"margin-left:10%;\">Current  Account Balances <br> Checking: $$currentchkBal <br>Savings: $$currentSavBal </h3><br>";
     
        // Then this while statement loops through the data in the database and returns the data
        // and stores it in the varaible names and dislay the transactions and the account balances 
        // main content to the user
        $mainContent .= getPendingTransaction($userId);
        $mainContent .= "<div style=\"margin-left:10%;\"><h2>Completed Transactions</h2></div>";
        while($row = mysqli_fetch_assoc($result)){
            $transactId = $row['transactionId'];
            $user = $row['userId'];
            $acctName = $row['accountName'];
            $ckBal = $row['checkingBalance'];
            $transAmt = $row['transferAmount'];
            $savBal = $row['savingsBalance'];
            $depAmt = $row['depositAmount'];
            $acctName = ucfirst($acctName);
        
            $mainContent .= "<div><table style=\"border: 2px solid black ;width:70%; text-align:left; background-color:#ff8989;\">";
            $mainContent .= "<tr><th>UserAccount Id: </th><td>$user</td></tr><tr><th>To Account: </th><td>$acctName</td></tr><tr><th>Transaction Id: </th><td>$transactId</td></tr><tr><th>Deposit amount:</th><td> $$depAmt</td></tr><tr><th>Transfer amount:</th><td> $$transAmt</td></tr><tr><th>Savings balance:</th> <td>$$savBal</td></tr> <tr><th> Checking balance: </th><td>$$ckBal</td></tr>"; 
        } 
        echo generatePage($mainContent);
    }   else{
        //this displays if there are no transactions to show to the user
        $mainContent .= "<div style=\" margin-left:20%; margin-top:10%;\"><h2>There are no transactions to show at this time</h2><br><img src=\"/img/depositMoney.jpg\" style=\"margin-bottom:5%;\"></div>";
         echo generatePage($mainContent);
    }      
}
// Function to get the transactions from the database for the user by user ID
function getPendingTransaction($userId){

    // This line sets the variable $database to the connectToDatabase function
    $database = connectToDataBase();

    // These two lines set the query to get the information from the acctBalance table in the database
    // by the user id number where the transactions in descending order and is the last tranasction entered into the database(limit=1)
    $query = "SELECT * FROM acctBalance WHERE userId = $userId ORDER BY transactionId DESC LIMIT 2";
    $result = mysqli_query($database,$query);
    
    $mainContent = "";

    // Thses two lines set the variables to the functions to get the checking and savings account balances
    $currentSavBal = getSavingsBalance($userId);
    $currentchkBal = getCheckingBalance($userId);

    // This if statment checks to see if there is any result in the database    
    if(mysqli_num_rows($result) > 0){
     
        // Then this while statement loops through the data in the database and returns the data
        // and stores it in the varaible names and dislay the transactions and the account balances 
        // main content to the user
        $mainContent .= "<div style=\"margin-left:10%;\"><h2>Pending Transaction</h2></div>";
        while($row = mysqli_fetch_assoc($result)){
            $transactId = $row['transactionId'];
            $user = $row['userId'];
            $acctName = $row['accountName'];
            $ckBal = $row['checkingBalance'];
            $savBal = $row['savingsBalance'];
            $depAmt = $row['depositAmount'];
            $transAmt = $row['transferAmount'];
            $acctName = ucfirst($acctName);
        
            $mainContent .= "<div><table style=\"border: 2px solid black ;width:70%; text-align:left; background-color:#ff8989;\">";
            $mainContent .= "<tr><th>User Account Id: </th><td>$user</td></tr><tr><th>Transaction Id: </th><td>$transactId</td></tr><tr><th>To Account: </th><td>$acctName</td></tr><tr><th>Deposit amount:</th><td> $$depAmt</td></tr><tr><th>Transfer amount:</th><td> $$transAmt</td></tr><tr><th>Savings balance:</th> <td>$$savBal</td></tr> <tr><th> Checking balance: </th><td>$$ckBal</td></tr>"; 
        } 
        return ($mainContent);
        
    }   else{
        //This displays if there are no transactions to show to the user
        $mainContent .= "<div style=\" margin-left:25%; margin-top:10%;\"><h2>There are no transactions to show at this time</h2><br><img src=\"/img/depositMoney.gif\" style=\"margin-bottom:5%; margin-left:5%;\"></div>";
        return ($mainContent);
    }      
}

?>
<script>
/*
    This if statement checks to see if the current url is legal.php?accepted=1, if it is:
    the window location redirects the user to the terms_accepted.php webpage where a message is displayed
    that url tampering was attempted and the user captures a flag for it
*/
const currentUrlString = window.location.href;
    if (currentUrlString == "http://localhost/about/legal.php?accepted=1"){
        window.location = "http://localhost/about/terms_accepted.php";
    }
    
 /*
    This function is activated when the accept terms button on the legal.php is clicked and
    displays an popup alert message to the user. When the alert message "ok" button is clicked 
    the user is then redirected to the Northern Phish & Loan's registration page
*/   
function clicked() {
    alert("Thank you for accepting our misleading and misguided terms! \n\nNot only are we unpredictable and unreliable, we have ALL of your money, personal data and your authorized consent to continue our non compliance in all situations as stated. \n\nThank you we appreciate not doing business with you \nat Northern Phish & Loan!\n\n You may now register for your account!"); window.location = "http://localhost/banking/register.php";
    }

/*
    This function is activated when the large red button on the team_info.php page is clicked and
    redirects the user to a funny fish video on youtube. 
*/   
function funnyVideo(){
    window.location = "https://www.youtube.com/watch?v=mHJ3l18YqNM_popup?autoplay=1&mode=theater";
    } 

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

let captchaCode = "";
let count = 0;

// This function generates the captcha code on the register.php webpage
function generateCaptcha() {

    // These two line get the form element canvas by id and sets the context to 2d
    const canvas = document.getElementById("captchaCanvas");
    const ctx = canvas.getContext("2d");
    
    // This line clears the previous captcha
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // This line generates a random 6-character string for the captcha number
    captchaCode = Math.random().toString(36).substring(2, 8).toUpperCase();
    
    // Thses lines set (text) style : name of font, font color and aligns the text in the center
    ctx.font = "30px Arial";
    ctx.fillStyle = "#333";
    ctx.textAlign = "center";
    
    // This slines loop 5 times and add visual noise (lines) to the captcha to prevent bot reading
    for (let i = 0; i < 5; i++) {
        ctx.strokeStyle = "rgba(0,0,0,0.2)";
        ctx.beginPath();
        ctx.moveTo(Math.random() * 150, Math.random() * 50);
        ctx.lineTo(Math.random() * 150, Math.random() * 50);
        ctx.stroke();
    }
    
    ctx.fillText(captchaCode, canvas.width/2, 35);
}


// This function validates the captcha code on the register.php webpage
function validateCaptcha() {
    // This line gets the user input captcha code from the input captcha text box in the registration form
    const userCaptcha = document.getElementById("userInput").value.toUpperCase();
    // This lline gets the element input h4 heading in the canvas section of the form
    // in the register.php page named message to the variable "msg"
    const msg = document.getElementById("message");
    // This line gets the submit button with the id of "btn" from the registration form to the variable "btn"
    let btn = document.getElementById("btn");

    
      // This if statement checks to see if the generated captcha code does not match the user input
      // and returns the msg.innerHTML to display the message Incorrect, try again with the font color red
    if (userCaptcha !== captchaCode) {
        msg.innerHTML = "Incorrect, try again.";
        msg.style.color = "red"; 

        // This line then calls the generateCaptcha function to create a new captcha code
        generateCaptcha();

        // This line clears the user's captcha text box of any previous text to a now empty text box
        document.getElementById('userInput').value = "";

        // This is the event listener which listens to the register btn for each click and count++
        // stores the number of clicks incrementing by 1 each time
        btn.addEventListener("click", function () {
        count++;
            // This if statement checks to see if the submission count of clicks is more than 2 
            // and displays the message that the user is now locked out, too many tries in the color red
            if (count > 2){
                msg.innerHTML = "That's it! You are now locked out, too many tries!";
                msg.style.color = "red";
            }
        });
    } 
  
}
</script>