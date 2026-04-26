<?php
/*
    change-password.php
    Form for a user to change their passsword.
*/
session_start();
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";

$mainContent = "";
$passwordError = "";
$retypePasswordError = "";
$currentPasswordPayload = new PayloadCharacteristics("");
$newPasswordPayload = new PayloadCharacteristics("");
$retypePasswordPayload = new PayloadCharacteristics("");
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isLoggedIn()){
        $conn = connectToDatabase();
        $currentPassword = $_POST["password"];
        $newPassword = $_POST["new-password"];
        $retypePassword = $_POST["retype-password"];
        $currentPasswordPayload = new PayloadCharacteristics($currentPassword);
        $newPasswordPayload = new PayloadCharacteristics($newPassword);
        $retypePasswordPayload = new PayloadCharacteristics($retypePassword);
        $userId = $_COOKIE["logged-in-user"];
        $user = userFromId((int)$userId);
        $passwordIsCorrect = $currentPassword == $user->password;
        $passwordsMatch = $newPassword == $retypePassword;
        
        if(!$passwordIsCorrect) {
            $passwordError = "Password Incorrect.";
        }
        if(!$passwordsMatch) {
            $retypePasswordError = "You must enter the same password twice.";
        }

        // This if statement checks to see if the the new password contains "SELECT * FROM users" 
        // if it does it will redirect to the sqlSuccess.php page
        if (str_contains($newPassword ,"SELECT * FROM users")){
            $mainContent .= "<script>window.location = \"http://localhost/banking/sqlSuccess.php\" </script>";
        }

        if($passwordIsCorrect && $passwordsMatch) {
            
            // This is a try and catch
            try{
                // This line is the query to update the users password
                $query = "UPDATE users SET password=\"$newPassword\" WHERE userId=\"$userId\"";
                $conn->query($query);
                // The html content that displays the password change was sucessful
                $mainContent .= "<h2 style=\"margin: 5% 0 0 30%;\"> Your password has now been changed</h2>";

            // This catches any sql exception and displays the html error message below to the user
            } catch (Exception $e){
                $mainContent .= "<h2 style=\"margin: 5% 0 0 30%;\"> <br> Nice try there Slick!! &#128514; <br> Your password contains sql injection!</h2>";
        
            }
        } else {
            
        }
    } else {
        header("Location: /banking/login.php");
    }
}   
    global $susIcon;
    $passwordChangeFormForm = new SimpleForm(
        name: "Change Password",
        fields: array(
            new SimpleFormField(
                type: "password",
                name: "password",
                accessibleName: "Current password",
                errorMessage: $passwordError,
                validationIcon: $currentPasswordPayload->isSuspect() ? $susIcon : null,
                isRequired: true
            ),
            new SimpleFormField(
                type: "password",
                name: "new-password",
                accessibleName: "New password",
                errorMessage: "",
                validationIcon: $newPasswordPayload->isSuspect() ? $susIcon : null,
                isRequired: true
            ),
            new SimpleFormField(
                type: "password",
                name: "retype-password",
                accessibleName: "Retype password",
                errorMessage: $retypePasswordError,
                validationIcon: $retypePasswordPayload->isSuspect() ? $susIcon : null,
                isRequired: true
            ),
        ),
        instructions: "",
        method: "POST",
        action: "/banking/change-password.php",
        submitButtonName: "Change Password"
    );
    $mainContent .= $passwordChangeFormForm->generateHtml();


echo generatePage($mainContent);