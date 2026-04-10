
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
 
 if($_SERVER['REQUEST_METHOD'] == "POST"){
  
    // These lines get the information from the user in the registration form and store the value in the $variableNames
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];   
    $lastname = $_POST["lastname"];
    $captchaCode = $_POST["captcha"];

    // This line sets the variable $database to the connectToDatabase function
    $database = connectToDatabase();

    // This if statement checks to see if the database is not connected and then sends an error message
    // and closes the connection
    if(!$database){
        die ("Connection Failed".$database->connect_error);
    } else {
         
        // This line inserts the infromation stored in the varaibles into the database table "users"
        $sql = "INSERT INTO users(username, password, firstName, lastName, email, isAdmin) VALUES ('$username', '$password','$firstname', '$lastname', '$email', False)";
    
        // This is a try and catch
        try{ 

            /*This if statement checks to see if the database and sql was executed, if it was executed it will
              display the customer account has been created */
            if(mysqli_query($database,$sql)){
            
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

} 
// This line displays the content on the webpage by calling the function generatePage()
echo generatePage($mainContent); 
?>
