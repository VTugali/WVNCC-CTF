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
