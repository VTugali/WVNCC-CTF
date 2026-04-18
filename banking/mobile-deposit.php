<?php
/*
    mobile-deposit.php
    Form for uploading check photographs.
    FIXME: I cannot upload files larger than 1 MB or so, the page crashes
    and does not congratulate me as it should. -Sean
*/

session_start();
include "/var/www/html/include/functions.php";
include "/var/www/html/banking/bankingFunctions.php";

$mainContent = "";
$error = "";
$status = "";

$mobileDepositForm = new SimpleForm(
    name: "Mobile Check Deposit",
    fields: array(
        new SimpleFormField(
            type: "file",
            name: "file-to-upload",
            accessibleName: "Select Photo",
            errorMessage: $error,
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
         new SimpleFormField(
            type: "hidden",
            name: "user_id",
            accessibleName: "UserId",
            isRequired: true
        ),
    ),
    instructions: "Snap a picture of a check and mobile deposit it here. Once the image is processed and reviewed, the funds will be deposited into your account.",
    method: "POST",
    action: "/banking/mobile-deposit.php",
    submitButtonName: "Upload Image"
);

if($_SERVER['REQUEST_METHOD'] == "POST") {

    // These lines get the information from the user in the mobile deopsit form and store the value in the $variableNames
    $mobileDepositAmt = $_POST['amount'];
    $recAcct = $_POST['to-account'];
    $userId = $_COOKIE["logged-in-user"];
    $user = userFromId((int)$userId);
    $chkingBal = getCheckingBalance($userId);
    $savingBal = getSavingsBalance($userId);

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

    // Format Restrictions
    $fileSizeLimitByte = 15000000; // File size is bytes. Equals to 15MB
    $maxFileSize = 50000000; // File size is bytes. Equals to 50MB
    $fileSizeLimitMB = $fileSizeLimitByte / 1000000;
    $allowedFileTypesStr = implode(", ", $permittedFileTypes);

    // Directory for Upload Files
    $fileUploadDirectory = "/var/www/html/uploads/";

    // File Info
    $filename = $_FILES["file-to-upload"]["name"];
    $fileSize = $_FILES["file-to-upload"]["size"];
    $tmpFilename = $_FILES["file-to-upload"]["tmp_name"];

    // Extra vars
    $targetFile = $fileUploadDirectory . basename($filename);
    $strFileName = htmlspecialchars(basename($filename));

    // Testing if the file is under the accepted file size, if $fileSizeLimit is enabled, otherwise it skips this code
    $fileIsTooLarge = $fileSize > $fileSizeLimitByte;
    $fileIsWayTooLarge = $fileSize > $maxFileSize;
    if($useFileSizeLimit && $fileIsTooLarge) {
        $error = "Sorry, the max file size is ". $fileSizeLimitMB ."MB";
    } else if(!$useFileSizeLimit && $fileIsTooLarge) {
        sleep(10);
        $error = "Congrats! You have pulled off a DOS attack! Your file was way too big, pal!";
    } elseif(!$useFileSizeLimit && $fileIsWayTooLarge) {
        sleep(20);
        $error = "Congrats! You pulled off a DOS attack, but it was way too big for our page! So you get some extra credit!";
    }
        if(!filenameIsPermitted($strFileName)) {
            $error = "File must contain $allowedFileTypesStr - \"$strFileName\" does not.";
        }
    //Uploading Files as long as it fits in the requirements
    if($error == "") {
        if(move_uploaded_file($tmpFilename, $targetFile)) {
            $status = "The file ". htmlspecialchars(basename($filename))." has been uploaded at <code>".$fileUploadDirectory."</code>";
        } else {
            http_response_code(500);
            $status = "Our systems were unable to process your check photo, but we don't know why. Try reloading the page and re-attaching the photo.";
        }
    }
}

if($status) {
    $mobileDepositForm->instructions .= "<p>$status</p>";
}
$mainContent .= $mobileDepositForm->generateHtml();
echo generatePage($mainContent);
    