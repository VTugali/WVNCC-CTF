
<?php
/*
    registerAction.php action page for the registration page.php webpage
    which enters the user into the database if it passes the captcha test
*/

session_start();
// These two line include the files for the functions for this page to call to be used
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";

 $mainContent = ""; 
   
 // This if statement checks to see if the server request from the form action is POST
 if($_SERVER['REQUEST_METHOD'] == "POST"){
  
    // These lines get the information from the user in the registration form and store the value in the $variableNames
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];   
    $lastname = $_POST["lastname"];
    $captchaCode = $_POST["captcha"];

    // This line sets the variable $database1 and datbase2 to the connectToDatabase function to connect
    // to the database for two different database insertions
    $database1 = connectToDatabase();
    $database2 = connectToDatabase();

    $new_Id = 0;
    $toAcct ="start";
    $paymentAmt = 0;
    $fromAcct = "";

    // This if statement checks to see if either database is not connected and then sends an error message
    // and closes the connection
    if(!$database1 || !$database2){

        die ("Connection Failed".$database1->connect_error);
        die ("Connection Failed".$database2->connect_error);
    } else {


        // This is a try and catch
        try{ 

                // This line is the query1 to insert the data into the database1 table acctBalance
            $query1 = "INSERT INTO users(username, password, firstName, lastName, email, isAdmin) VALUES ('$username', '$password','$firstname', '$lastname', '$email', False)";
            mysqli_query($database1, $query1);
            $newId = mysqli_insert_id($database1); // Gets the newly generated user ID
    
            // These lines set the variable names to the functions in the bankingFunctions.php page
            // to get the  morgage and darkvault cedit account starting balances to enter into the database
            $dkvBal  = getDkStartBalance($newId);
            $mgBal = getMgStartBalance($newId);  
    
            // This line is the query2 to insert the data into the database2 table loanBalance
            $query2 = "INSERT INTO loanBalance(userId, accountName,fromAcct,paymentAmount,morgageBalance, darkVaultBalance) VALUES('$newId', '$toAcct', '$fromAcct','$paymentAmt','$mgBal','$dkvBal')";    
            mysqli_query($database2, $query2);


            // This if statement checks to see if the database2 and query2 was executed, if it was executed
            //  it will display  the html content that the customer account has been created 
            if(mysqli_query($database2,$query2)){
                
                // Html content to display to the user
                $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
                $mainContent .= "<h2>Thanks for choosing Northern Phish &amp; Loan!<br> Your customer account has been created!</h2>";
                $mainContent .= "<h5 style=\"margin-left: 21%;\" >You can now log into your new account!</h5>";
                $mainContent .= "</div>";
            }
            
        // This catch will can any exceptions and return the message to the user that an error has occured 
        // to the webpage and display a funny gif character
        } catch (Exception $e){
            $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
            $mainContent .= "<h2 id=\"message\" style=\"margin-bottom:0;\">Thanks for choosing Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured registering your account,<br> please try again!</p></div>";
            $mainContent .= "<div style=\"margin-left:26%; margin-bottom:10%;\"><img src=\"/img/registerError.gif\" width=\"500px\"; height=\"500px\";></div>"; 
        }
    }
       // This line closes the database connection
    mysqli_close($database1);
    mysqli_close($database2);
} 

// This line displays the content on the webpage by calling the function generatePage()
echo generatePage($mainContent); 
?>
