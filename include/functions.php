<?php
/*
    functions.php
    Include this file to get all of the cool stuff.
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "/var/www/html/include/auth.php";
include "/var/www/html/include/formgen.php";
include "/var/www/html/include/accountcard.php";
include "/var/www/html/include/layout.php";
include "/var/www/html/include/transaction.php";

/**
 * An analysis of user input. Has methods for checking for XSS, SQL injection, etc.
 */
class PayloadCharacteristics {
    public string $payload;
    public function __construct(string $payload) {
        $this->payload = $payload;
    }
    public function isQuoteInjectionAttempt(): bool {
        return str_starts_with($this->payload, "'") || str_starts_with($this->payload, "\"");
    }
    public function isSqlCommentInjectionAttempt(): bool {
        return str_contains($this->payload, "--");
    }
    public function isSqlDeletionAttempt(): bool {
        $payload = strtoupper($this->payload);
        return str_contains($payload, "DELETE") || str_contains($payload, "DROP");
    }
    public function isSqlInjectionAttempt(): bool {
        return $this->isQuoteInjectionAttempt() || $this->isSqlCommentInjectionAttempt() || $this->isSqlDeletionAttempt();
    }
    public function isXssAttempt(): bool {
        return str_contains($this->payload, "<") && str_contains($this->payload, ">");;
    }
    public function isXssScriptAttempt(): bool {
        return str_contains($this->payload, "<script>") && str_contains($this->payload, "</script>");;
    }
    public function isSuspect(): bool {
        return $this->isSqlInjectionAttempt() || $this->isXssAttempt();
    }
}

/**
 * Connects to the 'breakTheBank' database.
 * @return bool|mysqli The Database connection.
 */
function connectToDatabase(): mysqli {
    return mysqli_connect("db", "root", "hackme", "breakTheBank");
}
?>

<script>
/*
    this function checks to see if the current url is legal.php?accepted=1, if it is:
    the window location redirects the user to the terms_accepted.php webpage where a message is displayed
    that url tampering was attempted and the user captures a flag for it
*/
const currentUrlString = window.location.href;
    if (currentUrlString == "http://localhost/about/legal.php?accepted=1"){
        window.location = "http://localhost/about/terms_accepted.php";
    }

 /*
    this function is activated when the accept terms button on the legal.php is clicked and
    displays an popup alert message to the user. When the alert message "ok" button is clicked 
    the user is then redirected to the Northern Phish & Loan's registration page
*/   
function clicked() {
    alert("Thank you for accepting our misleading and misguided terms! \n\nNot only are we unpredictable and unreliable, we have ALL of your money, personal data and your authorized consent to continue our non compliance in all situations as stated. \n\nThank you we appreciate not doing business with you \nat Northern Phish & Loan!\n\n You may now register for your account!"); window.location = "http://localhost/banking/register.php";
    }

/*
    this function is activated when the large red button on the team_info.php page is clicked and
    redirects the user to a funny fish video on youtube. 
*/   
function funnyVideo(){
    window.location = "https://www.youtube.com/watch?v=mHJ3l18YqNM_popup?autoplay=1&mode=theater";
    } 

</script>
