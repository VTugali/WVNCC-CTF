<?php
/*
    register.php
    Registration page for the site.
*/
session_start();
include "/var/www/html/include/functions.php";


$mainContent = "";
$registrationForm = new SimpleForm(
    name: "Register",
    fields: array(
         
        new SimpleFormField(
            type: "text",
            name: "username",
            accessibleName: "Username",
            defaultValue: "",
            options: array(),
            errorMessage: "",
            validationIcon: null,
            autofocus: false,
            isRequired: true
        ),
        new SimpleFormField(
            type: "password",
            name: "password",
            accessibleName: "Password",
            defaultValue: "",
            options: array(),
            errorMessage: "",
            validationIcon: null,
            autofocus: false,
            isRequired: true
        ),
        new SimpleFormField(
            type: "password",
            name: "retype-password",
            accessibleName: "Retype password",
            defaultValue: "",
            options: array(),
            errorMessage: "",
            validationIcon: null,
            autofocus: false,
            isRequired: true
        ),
        new SimpleFormField(
            type: "text",
            name: "firstname",
            accessibleName: "Firstname",
            defaultValue: "",
            options: array(),
            errorMessage: "",
            validationIcon: null,
            autofocus: false,
            isRequired: true
        ),
        new SimpleFormField(
            type: "text",
            name: "lastname",
            accessibleName: "Lastname",
            defaultValue: "",
            options: array(),
            errorMessage: "",
            validationIcon: null,
            autofocus: false,
            isRequired: true
        ),
        new SimpleFormField(
            type: "email",
            name: "email",
            accessibleName: "Email",
            defaultValue: "",
            options: array(),
            errorMessage: "",
            validationIcon: null,
            autofocus: false,
            isRequired: true
        )

    ),
    instructions: "Fill the following form to create your Northern Phish &amp; Loan mobile banking account. Once completed, you will need to go to your local Northern Phish branch to complete setup.",
    method: "POST",
    action: "/banking/register.php",
    submitButtonName: "Register"
);


 if($_SERVER['REQUEST_METHOD'] == "POST"){

    // These lines get the information from the user in the registration form and store the value in the $variableNames
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];   
    $lastname = $_POST["lastname"];

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
                $mainContent .= "<p>You can Login into your new account!</p>";
                $mainContent .= "</div>";
            }
        // This catch will can any exceptions and return the message to the user that an error has occured 
        // to the webpage and display a funny gif character
        } catch (Exception $e){
            $mainContent .= "<div class=\"single-column\" role=\"presentation\">";
            $mainContent .= "<h2 style=\"margin-bottom:0;\">Thanks for choosing Northern Phish &amp; Loan!</h2><p style=\"color:red; font-size:1.5rem;\"><br> An error has occured registering your account,<br> please try again!</p></div>";
            $mainContent .= "<div style=\"margin-left:25%; margin-bottom:10%;\"><img src=\"/img/giphy.webp\" width=\"500px\"; height=\"500px\";></div>"; 
        }
    }

} else {
    // Otherwise, show form
    $mainContent .= $registrationForm->generateHtml();
}

echo generatePage($mainContent); 
    