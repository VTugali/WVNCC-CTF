<?php 
  /*
    Banking functions page
*/

// This function gets the user first and last name by  user id
function getUserName($userId){

    // This line sets the variable $database to the connectToDatabase function to connect to the database
    $database = connectToDataBase();

    // These three lines set the query to get the information from the users table in the database
    // by the user id number
    $query = "SELECT * FROM users WHERE userId = $userId";
    $result = mysqli_query($database,$query);

    $mainContent = "";
    $fname = "";
    $lname = "";

    // This if statment checks to see if there is any result in the database
    if(mysqli_num_rows($result) > 0){

        // Then this while statement loops through the data in the database and returns the data
        // and stores it in the variable $fname and $lname and returns that value
        while($row = mysqli_fetch_assoc($result)){
            $fname = $row['firstName'];
            $lname= $row['lastName'];
        } 
        $mainContent .= "$fname $lname";  
    }  
    // This line closes the database connection
    mysqli_close($database);

    return ($mainContent);   
}


 // Function to get the Checking account balance from the database for the user by user ID
function getCheckingBalance($userId){

    // This line sets the variable $database to the connectToDatabase function to connect to the database
    $database = connectToDataBase();

    // These three lines set the query to get the information from the acctBalance table in the database
    // by the user id number
    $query = "SELECT * FROM acctBalance WHERE userId = $userId";
    $result = mysqli_query($database,$query);
    $chkingBal = 0;

    // This if statment checks to see if there is any result in the database
    if(mysqli_num_rows($result) > 0){

        // Then this while statement loops through the data in the database and returns the data
        // and stores it in the variable $schkngBal and returns that value
        while($row = mysqli_fetch_assoc($result)){
            $chkingBal = $row['checkingBalance'];
        } 
    }  
    // This line closes the database connection
    mysqli_close($database);

    // Checkings account balance amount returned
    return ($chkingBal) ;       
}


// Function to get the Savings account balance from the database for the user by user ID
function getSavingsBalance($userId){

    /// This line sets the variable $database to the connectToDatabase function to connect to the database
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

   // This line closes the database connection
    mysqli_close($database);

    // Savings account balance amount returned
    return ($savingBal) ;  
}


// Function to get the transactions from the database for the user by user ID
function getTransactions($userId){

   // This line sets the variable $database to the connectToDatabase function to connect to the database
    $database = connectToDataBase();

    // This line sets the variable $name to the function that gets the logged in user's first and 
    // last name by userid
    $name = getUserName($userId);

    // These two lines set the query to get the information from the acctBalance table in the database
    // by the user id number in descening order by transactionId and limits the amount of records 
    // returned to 10 and excludes the first one which is a pending transaction
    $query = "SELECT * FROM acctBalance WHERE userId = $userId ORDER BY transactionId DESC  LIMIT 15 OFFSET 1";
    $result = mysqli_query($database,$query);
    

    $mainContent = "";
    
    // These lines set the variables to the functions to get the checking, savings, morgage and 
    // darkvault credit account balances
    $currentSavBal = getSavingsBalance($userId);
    $currentchkBal = getCheckingBalance($userId);
    $currentDkvBal = getDkvBalance($userId);
    $currentMgBal = getMgBalance($userId);
  

    // This if statment checks to see if there is any result in the database    
    if(mysqli_num_rows($result) > 0){

        // This is the beginning of the html code that will be displayed to the user
        $mainContent .= "<body style=\"background-color: #c41230;color:white;\"><h1 style=\"margin: 2% 5%;\">Bank Transaction Information</h1> ";
        $mainContent .= "<h2 style=\"margin: 0 5%;\"><pre style=\"font-family: 'Courier New', monospace;\">Current Account Balances                          $name </pre><hr style=\"background-color:white; color:white; height:1%;\"></h2><h3 style=\"margin: 0 5%;font-size:1.3rem;\">Checking: $$currentchkBal <br>Savings: $$currentSavBal <br><br>Morgage Balance: $$currentMgBal<br>Dark Vault Credit Balance: $$currentDkvBal </h3>";
        $mainContent .= getPendingTransaction($userId);
        $mainContent .= "<div style=\"margin: 5% 10% 0% 10%; border: 1px solid black;background-color:#ff8989;color:black;\"><h2> &emsp; Completed Transactions</h2></div>";
        
        // Then this while statement loops through the data in the database and returns the data
        // and stores it in the variable names and dislay the transactions and the account balances 
        // in the variable $mainContent to display to the user     
        while($row = mysqli_fetch_assoc($result)){
            $transactId = $row['transactionId'];
            $user = $row['userId'];
            $toAcct = $row['accountName'];
            $fromAcct = $row['fromAcct'];
            $ckBal = $row['checkingBalance'];
            $transAmt = $row['transferAmount'];
            $paymentAmt = $row['paymentAmt'];
            $savBal = $row['savingsBalance'];
            $depAmt = $row['depositAmount'];
            
             
            // The html displayed to the user with the data from the database
            $mainContent .= "<table style=\"border: 2px solid black ;width:80%; background-color:#ff8989;color:black;\">";
            $mainContent .= "<tr><th style=\"text-align:left;border: 1px solid black;\">UserAccount Id:</th><td style=\"border: 1px solid black;\"><b>$user</b></td><td style=\"border: 1px solid black;\"><b>Balances</b></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">Transaction Id:</th><td>$transactId</td><td style=\"border: 1px solid black;\"></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">From Account:</th><td style=\"border: 1px solid black;\">$fromAcct</td><td style=\"border: 1px solid black;\"></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">To Account:</th><td style=\"border: 1px solid black;\">$toAcct</td><td style=\"border: 1px solid black;\"></td></tr>
            <tr><th style=\"text-align:left;border: 1px solid black;\">Deposit amount:</th><td style=\"border: 1px solid black;\">$$depAmt</td><td></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">Transfer amount:</th><td style=\"border: 1px solid black;\">$$transAmt</td><td style=\"border: 1px solid black;\"></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">Payment amount:</th><td style=\"border: 1px solid black;\">$$paymentAmt</td><td></td><tr><th style=\"text-align:left;border: 1px solid black;\">Savings balance:</th><td></td><td style=\"border: 1px solid black;\">$$savBal</td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">Checking balance:</th><td style=\"border: 1px solid black;\"></td><td style=\"border: 1px solid black;\">$$ckBal</td></tr></table>"; 
        } 
        
        // Displays the html content using the function generatePage()
        echo generatePage($mainContent);

    }   else{

        //This displays if there are no transactions to show to the user
        $mainContent .= "<div style=\" margin-left:25%; margin-top:10%;\"><h2>There are no transactions to show at this time</h2><br><img src=\"/img/depositMoney.jpg\" style=\"margin-bottom:5%;\"></div>";
        echo generatePage($mainContent);
    }
    // This line closes the database connection
    mysqli_close($database);     
}

// Function to get the pending transactions from the database for the user by user ID
function getPendingTransaction($userId){

    // This line sets the variable $database to the connectToDatabase function to connect to the database
    $database = connectToDataBase();

    // These two lines set the query to get the information from the acctBalance table in the database
    // by the user id number where the transactions in descending order and limited to
    // the last transaction entered into the database
    $query = "SELECT * FROM acctBalance WHERE userId = $userId ORDER BY transactionId DESC LIMIT 1";
    $result = mysqli_query($database,$query);
    
    $mainContent = "";

    // These lines set the variables to the functions to get the checking and savings account balances
    $currentSavBal = getSavingsBalance($userId);
    $currentchkBal = getCheckingBalance($userId);

    // This if statment checks to see if there is any result in the database    
    if(mysqli_num_rows($result) > 0){
     
        // This is the beginning of the html code that will be displayed to the user
        $mainContent .= "<hr style=\"margin: 1% 5%; background-color:white; color:white; height:1%;\"><div style=\"margin: 2% 10%; border: 1px solid black;background-color:#00eeee;color:black;\"><h2>&emsp; Pending Transaction</h2></div><div><table style=\"border: 2px solid black ;width:80%; text-align:left; background-color:#00eeee; color:black;\">";

        // Then this while statement loops through the data in the database and returns the data
        // and stores it in the variable names and dislay the transactions and the account balances 
        // main content to the user
        while($row = mysqli_fetch_assoc($result)){
            $transId = $row['transactionId'];
            $user_id = $row['userId'];
            $toAcct = $row['accountName'];
            $fromAcct = $row['fromAcct'];
            $ckBal = $row['checkingBalance'];
            $savBal = $row['savingsBalance'];
            $depAmt = $row['depositAmount'];
            $paymentAmt = $row['paymentAmt'];
            $transAmt = $row['transferAmount'];

            // The html displayed to the user with the data from the database
            $mainContent .= "<tr><th style=\"text-align:left;border: 1px solid black;\">UserAccount Id:</th><td style=\"border: 1px solid black;\"><b>$user_id</b></td><td style=\"border: 1px solid black;\"><b>Balances</b></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">Transaction Id:</th><td style=\"border: 1px solid black;\">$transId</td><tr><th style=\"text-align:left;border: 1px solid black;\">From Account:</th><td style=\"border: 1px solid black;\">$fromAcct</td><td style=\"border: 1px solid black;\"></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">To Account:</th><td style=\"border: 1px solid black;\">$toAcct</td><td style=\"border: 1px solid black;\"></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">Deposit amount:</th><td style=\"border: 1px solid black;\"> $$depAmt</td><td style=\"border: 1px solid black;\"></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">Transfer amount:</th><td style=\"border: 1px solid black;\">$$transAmt</td><td style=\"border: 1px solid black;\"></td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">Payment amount:</th><td style=\"border: 1px solid black;\">$$paymentAmt</td><td style=\"border: 1px solid black;\"></td><tr><th style=\"text-align:left;border: 1px solid black;\">Savings balance:</th><td style=\"border: 1px solid black;\"></td><td style=\"border: 1px solid black;\">$$savBal</td></tr><tr><th style=\"text-align:left;border: 1px solid black;\">Checking balance:</th><td style=\"border: 1px solid black;\"></td><td style=\"border: 1px solid black;\">$$ckBal</td></tr><table>"; 
        } 

        return ($mainContent);
        
    }   else{
        //This displays if there are no transactions to show to the user
        $mainContent .= "<div style=\" margin-left:25%; margin-top:10%;\"><h2>There are no transactions to show at this time</h2><br><img src=\"/img/depositMoney.gif\" style=\"margin-bottom:5%; margin-left:5%;\"></div>";
        return ($mainContent);
    }  
    // This line closes the database connection
    mysqli_close($database);   
}



// Function to create the Morgage starting balance and return the amount to insert in the database 
// for the user by user ID which is called in the register.php page when the user registers for 
// an account
function getMgStartBalance($userId){

    // This line creates a random number amount for the morgage starting balance
    $mgStartBal = mt_rand(5500000, 15000000)/100;

    //This line returns the amount
    return ($mgStartBal) ;   
}

// Function to create the Dark Vault  Credit starting balance and return the amount to insert in the 
// database for the user by user ID which is called in the register.php page when the user registers for 
// an account
function getDkStartBalance($userId){
 
    // This line creates a random number amount for the dark Vault Credit starting balance
    $dkvStartBal = mt_rand(100000, 650000)/100;

    //This line returns the amount
    return ($dkvStartBal) ;       
}



 // Function to get the Morgage account balance from the database for the user by user ID
function getMgBalance($userId){

    // This line sets the variable $database to the connectToDatabase function to connect to the database
    $database = connectToDataBase();

    // These three lines set the query to get the information from the loanBalance table in the database
    // by the user id number
    $query = "SELECT * FROM loanBalance WHERE userId = $userId";
    $result = mysqli_query($database,$query);
    $morgageBal = 0;

    // This if statment checks to see if there is any result in the database
    if(mysqli_num_rows($result) > 0){

        // Then this while statement loops through the data in the database and returns the data
        // and stores it in the variable $morgageBal and returns that value
        while($row = mysqli_fetch_assoc($result)){
            $morgageBal = $row['morgageBalance'];
        } 
    }  

   // This line closes the database connection
    mysqli_close($database);
    // Morgage account balance amount returned
    return ($morgageBal) ;       
}


 // Function to get the Dark Vault Credit account balance from the database for the user by user ID
function getDkvBalance($userId){

    // This line sets the variable $database to the connectToDatabase function to connect to the database
    $database = connectToDataBase();

    // These three lines set the query to get the information from the loanBalance table in the database
    // by the user id number
    $query = "SELECT * FROM loanBalance WHERE userId = $userId";
    $result = mysqli_query($database,$query);
    $darkVaultBal = 0;

    // This if statment checks to see if there is any result in the database
    if(mysqli_num_rows($result) > 0){

        // Then this while statement loops through the data in the database and returns the data
        // and stores it in the variable $darkVaultBal and returns that value
        while($row = mysqli_fetch_assoc($result)){
            $darkVaultBal = $row['darkVaultBalance'];
        } 
    }  
    // This line closes the database connection
    mysqli_close($database);
    // Dark Vault Credit account balance amount returned
    return ($darkVaultBal) ;       
}


// This function is to process the payments in the payments.php action page
function payments($userId,$frAcct, $toAcct,$paymentAmt,$deposit,$transferAmt,$chkingBal, $savingBal,$mgBal,$dkvBal){

// setting the payment format to 2 decimals
$paymentAmtFmt = sprintf("%.2f", $paymentAmt);

    $mainContent = "";

   
        //This line sets the variable $database1 and datbase2 to the connectToDatabase function to connect
        // to the database for two different database insertions
        $database1 = connectToDatabase();
        $database2 = connectToDatabase();

        // This if statement checks to see if either database is not connected and then sends an error message
        // and closes the connection
        if(!$database1 || !$database2){
            die ("Connection Failed".$database1->connect_error);
            die ("Connection Failed".$database2->connect_error);
        } else {
               
            // This is the if statement to check to see if the from account is the checking account
            if ($frAcct == "checking"){
                // This if statement checks to see if the to account is morgage
                if ($toAcct == "morgage"){

                    // This if statement checks to see it the checking balance is less than the payment amount
                    // if it is it will display the yo_no_money error page to the user
                    if($chkingBal < $paymentAmt){
                        $mainContent .= "<script> window.location.href = \"http://localhost/banking/yo_no_money.php\"; </script>";
                    } else {

                        // If there is enough money in the account, the payment is minused from checking balance 
                        // and minused from the outsanding morgage balance and both updated balances 
                        // are entered into the database
                        $chkingBal = $chkingBal - $paymentAmt;
                        $mgBal = $mgBal - $paymentAmt;

                        if ($mgBal >= 0.00){
                          
                            // This line is the query1 to insert the data into the database1 table acctBalance
                            $query1 = "INSERT INTO acctBalance(userId,accountName,fromAcct, depositAmount,transferAmount,paymentAmt,checkingBalance, savingsBalance) VALUES('$userId','$toAcct','$frAcct','$deposit', '$transferAmt','$paymentAmt', '$chkingBal','$savingBal')";
                            mysqli_query($database1, $query1);
                            
                            // This line is the query2 to insert the data into the database2 table loanBalance
                            $query2 = "INSERT INTO loanBalance(userId, accountName,fromAcct, paymentAmount,morgageBalance, darkVaultBalance) VALUES('$userId', '$toAcct', '$frAcct', '$paymentAmt','$mgBal','$dkvBal')";    
                            mysqli_query($database2, $query2);

                            // This is a try and catch
                            try{ 

                                // This if statement checks to see if the database2 and query2 was executed, if it was executed it will
                                // display that the payment was accepted and show the balance of the accounts to the user
                                if(mysqli_query($database2,$query2)){
                                   
                                    // This is the beginning of the html code with the database information that will be displayed to the user
                                    $mainContent .= "<body style=\"background-color: #c41230; color:white;\"><h2 style=\"margin-left:10%;margin-top:5%;\">Bank Transaction Information</h2> ";
                                    $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                                    $mainContent .= "<h2>Great news! <br>Your Morgage Payment: $$paymentAmtFmt <br> has been accepted! </h2>";
                                    
                                }

                            // This catch will can any exceptions and return the message to the user that an error has 
                            // occured to the webpage
                            } catch (Exception $e){
                                //The html to display to the user
                                $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                                $mainContent .= "<h2 style=\"margin-bottom:0;\">Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured with your payment,<br> please try again!</p></div>";
                            }  
                         
                        } else {
                            // This html displays when the account is trying to pay more than is owed
                            $mainContent .= "<body style=\"background-color:crimson;\"><div class=\"single-column\" role=\"presentation\">";
                            $mainContent .= "<h2 style=\"color:white;\"><pre>Did not process payment!<br> <br>Check your Morgage account balance!</h2></div>";
                            $mainContent .= "<div style=\"margin-left:30%; margin-bottom:10%;\"><img src=\"/img/paid.webp\" width=\"500px\"; height=\"500px\";></div>";
                        }
                    }   
                } else {

                    // This if statement checks to see if the to account is dark vault credit
                    if ($toAcct == "DVCredit"){

                        // This if statement checks to see it the checking balance is less than the payment amount
                        // if it is it will display the yo_no_money error page to the user
                        if($chkingBal < $paymentAmt){
                            $mainContent .= "<script> window.location.href = \"http://localhost/banking/yo_no_money.php\"; </script>";
                        } else {

                            // If there is enough money in the account, the payment is minused from checking balance 
                            // and minused from the outsanding dark vault credit balance and both updated balances 
                            // are entered into the database
                            $chkingBal = $chkingBal - $paymentAmt;
                            $dkvBal = $dkvBal - $paymentAmt;

                            if ($dkvBal >= 0.00){
                               
                                // This line is the query1 to insert the data into the database1 table acctBalance
                                $query1 = "INSERT INTO acctBalance(userId,accountName,fromAcct, depositAmount,transferAmount,paymentAmt,checkingBalance, savingsBalance) VALUES('$userId','$toAcct','$frAcct','$deposit', '$transferAmt','$paymentAmt', '$chkingBal','$savingBal')";
                                mysqli_query($database1, $query1);
                                
                                // This line is the query2 to insert the data into the database2 table loanBalance
                                $query2 = "INSERT INTO loanBalance(userId, accountName,fromAcct, paymentAmount,morgageBalance, darkVaultBalance) VALUES('$userId', '$toAcct', '$frAcct', '$paymentAmt','$mgBal','$dkvBal')";    
                                mysqli_query($database2, $query2);
                                
                                // This is a try and catch
                                try{ 

                                    // This if statement checks to see if the database and sql was executed, if it was executed it will
                                    // display that the payment was accepted and show the balance of the accounts to the user
                                    if(mysqli_query($database2,$query2)){

                                        // The  html content to display to the user with the database information
                                        $mainContent .= "<body style=\"background-color: #c41230;color:white;\"><div class=\"single-column\" role=\"presentation\">";
                                        $mainContent .= "<h2>Great news! <br>Your Dark Vault Credit Payment : $$paymentAmtFmt <br> has been accepted! </h2>";
                                        
                                    } 
                                // This catch will can any exceptions and return the message to the user 
                                // that an error has occured to the webpage
                                } catch (Exception $e){
                                    $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                                    $mainContent .= "<h2 style=\"margin-bottom:0;\">Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured with your payment,<br> please try again!</p></div>";
                                }  

                            } else {

                               // This html displays when the account is trying to pay more than is owed
                                $mainContent .= "<body style=\"background-color:crimson;\"><div class=\"single-column\" role=\"presentation\">";
                                $mainContent .= "<h2 style=\"color:white;\"><pre>Did not process payment!<br> <br>Check your Dark Vault Credit account balance!</h2></div>";
                                $mainContent .= "<div style=\"margin-left:30%; margin-bottom:10%;\"><img src=\"/img/paid.webp\" width=\"500px\"; height=\"500px\";></div>";
                            }
                        }    
                    }
                }
            }
            // This is the if statement to check to see if the from account is the saving account
            if ($frAcct == "saving"){
                // This if statement checks to see if the to account is morgage
                if ($toAcct == "morgage"){

                    // This if statement checks to see it the savings balance is less than the payment amount
                    // if it is, it will display the yo_no_money error page to the user
                    if($savingBal < $paymentAmt){
                        $mainContent .= "<script> window.location.href = \"http://localhost/banking/yo_no_money.php\"; </script>";
                    } else {

                        // If there is enough money in the account, the payment is minused from savings 
                        // balance and minused from the outsanding morgage balance and both updated balances 
                        // are entered into the database
                        $savingBal = $savingBal - $paymentAmt;
                        $mgBal = $mgBal - $paymentAmt;

                        if ($mgBal >= 0.00){
                          
                             // This line is the query1 to insert the data into the database1 table acctBalance
                            $query1 = "INSERT INTO acctBalance(userId,accountName,fromAcct, depositAmount,transferAmount,paymentAmt,checkingBalance, savingsBalance) VALUES('$userId','$toAcct','$frAcct','$deposit', '$transferAmt','$paymentAmt', '$chkingBal','$savingBal')";
                            mysqli_query($database1, $query1);

                            // This line is the query2 to insert the data into the database2 table loanBalance
                            $query2 = "INSERT INTO loanBalance(userId, accountName,fromAcct, paymentAmount,morgageBalance, darkVaultBalance) VALUES('$userId', '$toAcct', '$frAcct', '$paymentAmt','$mgBal','$dkvBal')";    
                            mysqli_query($database2, $query2);

                            // This is a try and catch
                            try{ 

                                // This if statement checks to see if the database2 and query2 was executed, if it was executed it will
                                // display that the payment was accepted and show the balance of the accounts to the user
                                if(mysqli_query($database2,$query2)){

                                    // html to display to the user's webpage
                                    $mainContent .= "<body style=\"background-color: #c41230;color:white;\"><div class=\"single-column\" role=\"presentation\">";
                                    $mainContent .= "<h2>Great news! <br>Your Morgage Payment : $$paymentAmtFmt has been accepted! </h2>";
                                }

                            // This catch will can any exceptions and return the message to the user that
                            //  an error has occured to the webpage
                            } catch (Exception $e){
                                $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                                $mainContent .= "<h2 style=\"margin-bottom:0;\">Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured with your payment,<br> please try again!</p></div>";
                            }        
                        } else {

                            // This html displays when the account is trying to pay more than is owed
                            $mainContent .= "<body style=\"background-color:crimson;\"><div class=\"single-column\" role=\"presentation\">";
                            $mainContent .= "<h2 style=\"color:white;\"><pre>Did not process payment!<br> <br>Check your Morgage account balance!</h2></div>";
                            $mainContent .= "<div style=\"margin-left:30%; margin-bottom:10%;\"><img src=\"/img/paid.webp\" width=\"500px\"; height=\"500px\";></div>";
                        }
                    }
                        
                } else {

                    // This if statement checks to see if the to account is dark vault credit
                    if ($toAcct == "DVCredit"){

                         // This if statement checks to see it the savings balance is less than the payment amount
                        // if it is, it will display the yo_no_money error page to the user
                        if($savingBal < $paymentAmt){
                            $mainContent .= "<script> window.location.href = \"http://localhost/banking/yo_no_money.php\"; </script>";
                        } else {

                            // If there is enough money in the account, the payment is minused from savings 
                            // balance and minused from the outsanding dark vault credit balance and both
                            //  updated balances are entered into the database
                            $savingBal = $savingBal - $paymentAmt;
                            $dkvBal = $dkvBal - $paymentAmt;
                            
                            if ($dkvBal >= 0.00){

                                // This line is the query1 to insert the data into the database1 table acctBalance
                                $query1 = "INSERT INTO acctBalance(userId,accountName,fromAcct, depositAmount,transferAmount,paymentAmt,checkingBalance, savingsBalance) VALUES('$userId','$toAcct','$frAcct','$deposit', '$transferAmt','$paymentAmt', '$chkingBal','$savingBal')";
                                mysqli_query($database1, $query1);           

                                // This line is the query2 to insert the data into the database2 table loanBalance
                                $query2 = "INSERT INTO loanBalance(userId, accountName,fromAcct, paymentAmount,morgageBalance, darkVaultBalance) VALUES('$userId', '$toAcct', '$frAcct', '$paymentAmt','$mgBal','$dkvBal')";    
                                mysqli_query($database2, $query2);

                                // This is a try and catch
                                try{ 

                                    // This if statement checks to see if the database2 and query2 was executed, if it was executed it will
                                    // display that the transfer was accepted and show the balance of the accounts to the user
                                    if(mysqli_query($database2,$query2)){

                                        // Beginning html content to display to the user
                                        $mainContent .= "<body style=\"background-color: #c41230;color:white\"><div class=\"single-column\" role=\"presentation\">";
                                        $mainContent .= "<h2>Great news! <br>Your Dark Vault Payment : $$paymentAmtFmt has been accepted! </h2>";
                                        
                                    }

                                // This catch will can any exceptions and return the message to the user 
                                // that an error has occured to the webpage
                                } catch (Exception $e){
                                    $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                                    $mainContent .= "<h2 style=\"margin-bottom:0;\">Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured with your payment,<br> please try again!</p></div>";
                                }      
                            } else {

                                // This html displays when the account is trying to pay more than is owed
                                $mainContent .= "<body style=\"background-color:crimson;\"><div class=\"single-column\" role=\"presentation\">";
                                $mainContent .= "<h2 style=\"color:white;\"><pre>Did not process payment!<br> <br>Check your Dark Vault Credit account balance!</h2></div>";
                                $mainContent .= "<div style=\"margin-left:30%; margin-bottom:10%;\"><img src=\"/img/paid.webp\" width=\"500px\"; height=\"500px\";></div>";
                            }
                        }
                    }
                }
            }
        }
    
        // These 2 lines close the database connections
        mysqli_close($database1);
        mysqli_close($database2);


// This line displays the webpage content in $mainContent to the user 
// by calling the function generatePage() end of payments function
echo generatePage($mainContent);

}

// This function is to detect successful sql injection of "SELECT * FROM users" in the change-password.php page
function sqlInjection(){

    // This line sets the variable $database to the connectToDatabase function to connect to the database
    $database = connectToDatabase();
    $mainContent = "";

    // This line is the query to select all from the users table in the database and stores the 
    // result of the query in the variable $result
    $query = "SELECT * FROM users";
    $result = mysqli_query($database,$query);

    // This if statment checks to see if there is any result in the database  
    // if there  is the while loop will fetch the results
    if(mysqli_num_rows($result) > 0){

        // sucessful sql injection message to display to the user
        $mainContent .= "<h2 style=\"margin: 5% 0 0 30%;\">Ok, Ninja Hacker! &#129315;<br> You have sucessfully used sql injection! &#128681 </h2>";
        $mainContent .= "<table id=\"meet-our-team\">";
        
        // Thsi while loop will fetch the results and stores them in the variable names for the webpage display inside a table to the user in $mainContent
        while($row = mysqli_fetch_assoc($result)){
            $userName = $row["username"];
            $userPassword = $row["password"];
            $mainContent .= "<tr><td> $userName</td><td>$userPassword</td></tr>";
          
        }
        // end of html table element
        $mainContent .= "</table>";

        // This line closes the database connection
        mysqli_close($database);
        // returns the html maincontent to display to the user
        return ($mainContent);
    }
}
 
// This function checks the hash value and compares it to catch the 
// man in the middle attack in the paymentAction.php page
function processPayment($ss,$userId,$frAcct, $toAcct,$paymentAmt,$deposit,$transferAmt){
    
    $mainContent = "";

    // This if statenment checks to see if the value of $ss equals the  hashed $userId 
    // if they are the same it then calls the function Payments to process the payment transaction
    if (hash_equals($ss, hash('sha256', (string)$userId))) {

        // These lines set the variable names to the functions to get the checking,savings, morgage and
        // darkvault cedit account balances
        $chkingBal = getCheckingBalance($userId);
        $savingBal = getSavingsBalance($userId);
        $mgBal = getMgBalance($userId);
        $dkvBal = getDkvBalance($userId);

        //  This line calls the payments function
        payments($userId,$frAcct, $toAcct,$paymentAmt,$deposit,$transferAmt,$chkingBal, $savingBal,$mgBal,$dkvBal);
    
    // This else activates if the hashed values are not the same indicating man in the middle attack
    //  and will display a message to the attacker that they have been caught and receive a flag 
    // for their efforts
    }else{
    
        $mainContent = "";
        $mainContent .= "<body style=\"background-color:C0112F\"><div style=\"background-color:#F0F8FF; border: 2px solid black;  margin:5% 15% 2% 15%;\" >";
        $mainContent .= "<h1 style=\"margin:5% 0 1% 15%;\"> Hmm &#129300; not sly enough! Man in the Middle! <br> You have been caught red handed!! <img src=\"/img/hacker.jpg\" style=\"margin:1% 10% ;width:250px; height:250px;\"><br> Lol, you still capture a Flag for your efforts!! &#128681; </h2>";
        $mainContent .= "<p style=\"margin-left:16%; font-size:x-large; \"> <br> Continue on with your website mischief !! &#128521</p></div>";
        echo generatePage ($mainContent);    
    }
}

// This function checks the hash value and compares it to catch the 
// man in the middle attack in the transfer.php page
function processTransfer($ss,$transferAmt,$toAcct,$fromAcct,$userId){
    $mainContent = "";

    // This if statement checks to see if the value of $ss equals the  hashed $userId
    // if they are the same it then it will connect to the database and process the transfer transaction
    if (hash_equals($ss, hash('sha256', (string)$userId))) {

        // These lines set the variables to the functions to get the checking and savings account balances
        $chkingBal = getCheckingBalance($userId);
        $savingBal = getSavingsBalance($userId);

        // This line sets the variable $database to the connectToDatabase function
        $database = connectToDatabase();

        // This if statement checks to see if the database is not connected and then sends an error message
        // and closes the connection
        if(!$database){
            die ("Connection failed: " .connect->connect_error);
        } else {
                $deposit = 0.001;
            // This if statement is to display an error message to the user if the transfer funds receiving
            // and sending accounts are the same
            if ($toAcct === "saving" && $fromAcct == "saving" || $toAcct === "checking" && $fromAcct == "checking") {
                $mainContent .= "<div class=\"single-column\" role=\"presentation\"><h2 style=\"color:red;margin:0;\"> Error message: <br> An error has occured processing your funds Transfer</h2><br><h3> Please make sure the sending and receiving accounts are not the same!</h3></div>";
            } else {                
                // This if statement will check to see if the savings account balance is less than 
                // or equal to the transfer funds amount, if it is it will send the user to the error 
                // page yo_no_money.php with a funny gif character
                if($savingBal <= $transferAmt){
                    $mainContent .= "<script> window.location.href = \"http://localhost/banking/yo_no_money.php\"; </script>";

                }else{

                    // This if statement will check to see if the receiving account is the checking account 
                    // and not the sending account is not checking
                    if ($toAcct ==  "checking" && $fromAcct != "checking"){

                        /* These two lines take the transfer funds amount and deducts it from the savings account 
                        balance and adds it to the checking account balance */
                        $savingBal = $savingBal - $transferAmt;
                        $chkingBal = $chkingBal + $transferAmt;
                        
                        // This line is the sql to insert the data into the database table acctBalance
                        $sql = "INSERT INTO acctBalance(userId,accountName,fromAcct,depositAmount,transferAmount,checkingBalance, savingsBalance) VALUES('$userId','$toAcct','$fromAcct','$deposit', '$transferAmt', '$chkingBal','$savingBal')";

                        // This is a try and catch
                        try{ 

                            // This if statement checks to see if the database and sql was executed, if it was executed it will
                            // display that the transfer was accepted and show the balance of the accounts to the user
                            if(mysqli_query($database,$sql)){
                            
                                $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                                $mainContent .= "<h2>Great news! <br>Bank transfer has been accepted! </h2>";
                                $mainContent .= "<h2 style=\"margin-bottom:0px;\"><span style=\"color:red;\">Checking account balance: </span> $$chkingBal <br> <span style=\"color:red;\">Savings account balance: </span>$$savingBal </h2></div>";
                            }

                        // This catch will can any exceptions and return the message to the user that an error has occured to the webpage
                        } catch (Exception $e){
                            $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                            $mainContent .= "<h2 style=\"margin-bottom:0;\">Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured with your deposit,<br> please try again!</p></div>";
                        }        
                    } 
                } 
    
                    
                // This if statement will check to see if the checking account balance is less than or equal 
                // to the transfer funds amount, if it is it will send the user to the error page yo_no_money.php
                if($chkingBal <= $transferAmt){
                    $mainContent .= "<script> window.location.href = \"http://localhost/banking/yo_no_money.php\"; </script>";
                }else{

                    // This if statement will check to see if the receiving account is the saving account 
                    // and not the sending account is not savings
                    if($toAcct === "saving" && $fromAcct !== "saving"){

                        /* These two lines take the transfer funds amount and deducts it from the checking account 
                        balance and adds it to the savings account balance */
                        $chkingBal = $chkingBal - $transferAmt;
                        $savingBal = $savingBal + $transferAmt;
                        
                    // This line is the sql to insert the data into the database table acctBalance
                        $sql = "INSERT INTO acctBalance(userId,accountName,fromAcct,depositAmount,transferAmount,checkingBalance, savingsBalance) VALUES('$userId','$toAcct','$fromAcct','$deposit', '$transferAmt', '$chkingBal','$savingBal')";
                    
                        // This is a try and catch
                        try{ 

                            // This if statement checks to see if the database and sql was executed, if it was executed it will
                            // display that the transfer was accepted and show the balance of the accounts to the user
                            if(mysqli_query($database,$sql)){
                            
                                $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                                $mainContent .= "<h2>Great news! <br>Bank transfer has been accepted! </h2>";
                                $mainContent .= "<h2 style=\"margin-bottom:0px;\"><span style=\"color:red;\">Checking account balance:</span> $$chkingBal <br> <span style=\"color:red;\">Savings account balance: </span>$$savingBal</h2></div>";
                            }
                        
                        // This catch will can any exceptions and return the message to the user that an error has occured to the webpage
                        } catch (Exception $e){
                            $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                            $mainContent .= "<h2 style=\"margin-bottom:0;\">Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured with your deposit,<br> please try again!</p></div>";
                        }
                    }
                } 
            }
        }   
    // This else activates if the hashed values are not the same indicating man in the middle attack
    //  and will display a message to the attacker that they have been caught and receive a flag 
    // for their efforts
    } else {

        $mainContent = "";
        $mainContent .= "<body style=\"background-color:C0112F\"><div style=\"background-color:#F0F8FF; border: 2px solid black;  margin:5% 15% 2% 15%;\" >";
        $mainContent .= "<h1 style=\"margin:5% 0 1% 15%;\"> Hmm &#129300; not sly enough! Man in the Middle! <br> You have been caught red handed!! <img src=\"/img/hacker.jpg\" style=\"margin:1% 10% ;width:250px; height:250px;\"><br> Lol, you still capture a Flag for your efforts!! &#128681; </h2>";
        $mainContent .= "<p style=\"margin-left:16%; font-size:x-large; \"> <br> Continue on with your website mischief !! &#128521</p></div>"; 
    }
    // This line closes the database connection
    mysqli_close($database);

    echo generatePage($mainContent);  
}

// This function checks the hash value and compares it to catch the 
// man in the middle attack in the mobile-deposit.php page
function processMobile($ss,$userId,$mobileDepositAmt,$recAcct){
    $mainContent = "";

    // These lines set the variables to the functions to get the checking and savings account balances
    $chkingBal = getCheckingBalance($userId);
    $savingBal = getSavingsBalance($userId);

    // This if statement checks to see if the value of $ss equals the  hashed $userId
    // if they are the same it then it will connect to the database and process the transfer transaction
    if (hash_equals($ss, hash('sha256', (string)$userId))) {
        
        $transAmt = 0;
        $paymentAmt = 0;
    
        // This line sets the variable $database to the connectToDatabase function
        $database = connectToDatabase();

        // This if statement checks to see if the database is not connected and then sends an error message
        // and closes the connection
        if(!$database){
            die ("Connection failed: " .connect->connect_error);
        } else {
                
                /*This if statement will check to see if the receiving account is the checking account, if it is
                it then takes the mobile deposit amount  and adds it to the checking account balance and stores it in
                the new variable $newCheckingAccountBalance */
                if ($recAcct ==  "checking"){
                
                    $newCheckingAcctBalance = 0;

                    $chkingBal = $chkingBal + $mobileDepositAmt;
                    $newCheckingAcctBalance = $newCheckingAcctBalance + $chkingBal;

                    $newCheckingBal = sprintf("%.2f", $newCheckingAcctBalance);

                    // This line is the sql to insert the data into the database table acctBalance
                    $sql = "INSERT INTO acctBalance(userId,accountName,depositAmount,transferAmount,paymentAmt,checkingBalance, savingsBalance) VALUES('$userId','$recAcct', '$mobileDepositAmt','$transAmt','$paymentAmt', '$newCheckingAcctBalance','$savingBal')";

                
                    // This is a try and catch
                    try{ 

                        // This if statement checks to see if the database and sql was executed, if it was executed it will
                        // display the that the deposit was successful and shows the new checking blance total
                        if(mysqli_query($database,$sql)){
                        
                            $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                            $mainContent .= "<h2>Your deposit to checking has been accepted! <br> Your current <span style=\"color:red;\">checking account </span>balance is : $$newCheckingBal</h2>";
                            $mainContent .= "</div>";
                        }
                    // This catch will can any exceptions and return the message to the user that an error has occured to the webpage
                    } catch (Exception $e){
                        $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                        $mainContent .= "<h2 style=\"margin-bottom:0;\">Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured with your deposit,<br> please try again!</p></div>";
                    }
                } 
                /*This if statement will check to see if the receiving account is the savings account, if it is
                it then takes the mobile deposit amount  and adds it to the savings account balance and stores it in
                the new variable $newSavingsAccountBalance */
                if ($recAcct == "saving"){
                
                    $newSavingsAcctBalance = 0 ;
                    $savingBal = $savingBal + $mobileDepositAmt;
                    $newSavingsAcctBalance = $newSavingsAcctBalance + $savingBal;

                    $newSavingsBal = sprintf("%.2f", $newSavingsAcctBalance);
                    // This line is the sql to insert the data into the database table acctBalance
                    $sql = "INSERT INTO acctBalance(userId,accountName,depositAmount,transferAmount,paymentAmt,checkingBalance, savingsBalance) VALUES('$userId','$recAcct','$mobileDepositAmt','$transAmt', '$paymentAmt', '$chkingBal','$newSavingsAcctBalance')";

                    // This is a try and catch
                    try{ 

                        //This if statement checks to see if the database and sql was executed, if it was executed it will
                        // display the that the deposit was successful and shows the new savings blance total
                        if(mysqli_query($database,$sql)){
                        
                            $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                            $mainContent .= "<h2 style=\"margin-bottom:0px;\">Your deposit to savings has been accepted! <br> Your current <span style=\"color:red;\">savings account </span>balance is : <br> $ $newSavingsBal</h2>";
                            $mainContent .= "</div>";
                        }
                    // This catch will can any exceptions and return the message to the user that an error has occured to the webpage
                    } catch (Exception $e){
                        $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                        $mainContent .= "<h2 style=\"margin-bottom:0;\">Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured with your deposit,<br> please try again!</p></div>";
                    }
                } 
        }
    // This else activates if the hashed values are not the same indicating man in the middle attack
    //  and will display a message to the attacker that they have been caught and receive a flag 
    // for their efforts
    } else {

        $mainContent = "";
        $mainContent .= "<body style=\"background-color:C0112F\"><div style=\"background-color:#F0F8FF; border: 2px solid black;  margin:5% 15% 2% 15%;\" >";
        $mainContent .= "<h1 style=\"margin:5% 0 1% 15%;\"> Hmm &#129300; not sly enough! Man in the Middle! <br> You have been caught red handed!! <img src=\"/img/hacker.jpg\" style=\"margin:1% 10% ;width:250px; height:250px;\"><br> Lol, you still capture a Flag for your efforts!! &#128681; </h2>";
        $mainContent .= "<p style=\"margin-left:16%; font-size:x-large; \"> <br> Continue on with your website mischief !! &#128521</p></div>"; 
    }
    // This line closes the database connection
    mysqli_close($database);

    echo generatePage($mainContent);
}
?>

<script>

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
    // This line gets the element input h4 heading in the canvas section of the form
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

        // This is the button event listener which listens to the register btn for each click and count++
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