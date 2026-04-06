<?php
/*
    transfer funds page
*/

session_start();
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";

$mainContent = "";

$transferForm = new SimpleForm(
    name: "Transfer Funds",
    fields: array(
        new SimpleFormField(
            type: "select",
            name: "from-account",
            accessibleName: "Sending account",
            options: array("Checking", "Saving"),
            isRequired: true
        ),
        new SimpleFormField(
            type: "select",
            name: "to-account",
            accessibleName: "Receiving Account",
            defaultValue: "",
            options: array(
                "checking" => "Checking", 
                "saving" => "Saving"
            ),
            isRequired: true
        ),
        new SimpleFormField(
            type: "text",
            name: "amount",
            accessibleName: "Amount",
            isRequired: true
        ),
    ),
    instructions: "",
    method: "POST",
    action: "/banking/transfer.php",
    submitButtonName: "Transfer Funds"
);


if($_SERVER['REQUEST_METHOD'] == "POST") {

     // These lines get the information from the user in the tranfer form and store the value in the $variableNames
    $transferAmt = $_POST['amount'];
    $toAcct = $_POST['to-account'];
    $fromAcct = $_POST['from-account'];

    //These two lines get the user id from the cookie of the logged in user
    $userId = $_COOKIE["logged-in-user"];
    $user = userFromId((int)$userId);

    // Thses two lines set the variables to the functions to get the checking and savings account balances
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
            // This if statement will check to see if the receiving account is the checking account
            if ($toAcct ==  "checking"){
                
                // This if statement will check to see if the savings account balance is less than 
                // or equal to the transfer funds amount, if it is it will send the user to the error 
                // page yo_no_money.php with a funny gif character
                if($savingBal <= $transferAmt){
                    header("Location: /banking/yo_no_money.php");
                
                }else{

                /* These two lines take the transfer funds amount and deducts it from the savings account 
                balance and adds it to the checking account balance */
                $savingBal = $savingBal - $transferAmt;
                $chkingBal = $chkingBal + $transferAmt;
                
               // This line is the sql to insert the data into the database table acctBalance
                    $sql = "INSERT INTO acctBalance(userId,accountName,depositAmount,transferAmount,checkingBalance, savingsBalance) VALUES('$userId','$toAcct','$deposit', '$transferAmt', '$chkingBal','$savingBal')";

                // This is a try and catch
                try{ 

                    // This if statement checks to see if the database and sql was executed, if it was executed it will
                    // display that the transfer was accepted and show the balance of the accounts to the user
                    if(mysqli_query($database,$sql)){
                    
                        $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                        $mainContent .= "<h2>Great news! <br>Bank transfer has been accepted! </h2>";
                        
                        // These two lines set the variables to the functions to get 
                        // the balances for the checking and savings accounts
                        $currentSavBal = getSavingsBalance($userId);
                        $currentchkBal = getCheckingBalance($userId);
                        $mainContent .= "<h2 style=\"margin-bottom:0px;\"><span style=\"color:red;\">Checking account balance: </span> $$currentchkBal <br> <span style=\"color:red;\">Savings account balance: </span>$$currentSavBal </h2></div>";
                    }

                // This catch will can any exceptions and return the message to the user that an error has occured to the webpage
                } catch (Exception $e){
                    $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                    $mainContent .= "<h2 style=\"margin-bottom:0;\">Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured with your deposit,<br> please try again!</p></div>";
                }
                
            } }

            // This if statement will check to see if the receiving account is the savings account
            if($toAcct == "saving") {

                // This if statement will check to see if the checking account balance is less than or equal 
                // to the transfer funds amount, if it is it will send the user to the error page yo_no_money.php
                if($chkingBal <= $transferAmt){
                    header("Location: /banking/yo_no_money.php");
                }else{

                    /* These two lines take the transfer funds amount and deducts it from the checking account 
                    balance and adds it to the savings account balance */
                    $chkingBal = $chkingBal - $transferAmt;
                    $savingBal = $savingBal + $transferAmt;
                    
                   // This line is the sql to insert the data into the database table acctBalance
                    $sql = "INSERT INTO acctBalance(userId,accountName,depositAmount,transferAmount,checkingBalance, savingsBalance) VALUES('$userId','$toAcct','$deposit', '$transferAmt', '$chkingBal','$savingBal')";
                   
                    // This is a try and catch
                    try{ 

                        // This if statement checks to see if the database and sql was executed, if it was executed it will
                        // display that the transfer was accepted and show the balance of the accounts to the user
                        if(mysqli_query($database,$sql)){
                        
                            $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                            $mainContent .= "<h2>Great news! <br>Bank transfer has been accepted! </h2>";

                            // These two lines set the variables to the functions to get 
                            // the balances for the checking and savings accounts
                            $currentSavBal = getSavingsBalance($userId);
                            $currentchkBal = getCheckingBalance($userId);
                            $mainContent .= "<h2 style=\"margin-bottom:0px;\"><span style=\"color:red;\">Checking account balance:</span> $$currentchkBal <br> <span style=\"color:red;\">Savings account balance: </span>$$currentSavBal</h2></div>";
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

$mainContent .= $transferForm->generateHtml();
echo generatePage($mainContent);