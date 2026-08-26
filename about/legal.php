<?php
/*
    legal.php
    Static page with the terms of service from Grant.
*/
session_start();
include "/var/www/html/include/functions.php";

$mainContent = "";
$mainContent .= "<h2 id=\"attribution\">Attribution</h2>";
$mainContent .= "<ul>";
$mainContent .= "<li>Search and feedback banner graphics provided by <a href=\"https://www.vecteezy.com/\" target=\"_blank\">Vecteezy</a>.</li>";
$mainContent .= "<li>Loan application banner graphic from <a href=\"https://www.pexels.com/@mikhail-nilov/collections//\" target=\"_blank\">Mikhail Nilov of pexels.com</a>.</li>";
$mainContent .= "<li>\"That looks a lot like JavaScript\" image from <a href=\"https://www.instagram.com/therock/\" target=\"_blank\">Dwayne \"The Rock\" Johnson</a>.</li>";
$mainContent .= "<li>User account names from <a href=\"https://1000randomnames.com/\">1000randomnames.com</a>.</li>";
$mainContent .= "<li>Form submission graphic taken from <a href=\"https://www.innersloth.com/games/among-us/\">Innersloth games</a> under fair use.</li>";
$mainContent .= "<li>Richard Nixon portrait from <a href=\"https://en.wikipedia.org/wiki/Richard_Nixon#/media/File:Richard_Nixon_presidential_portrait_(1).jpg\" target=\"_blank\">Wikimedia Commons</a>.</li>";
$mainContent .= "<li>Additonal images with permission from <a href=\"https://www.wvncc.edu\" target=\"_blank\">West Virginia Northern Community College</a>.</li>";
$mainContent .= "<li>'This is Fine' comic made by <a href=\"https://www.kcgreendotcom.com/index.html\">KC Green.</a></li>";
$mainContent .= "<li>The monkey puppet image is from the Japanese children's show 'Ōkiku Naru Ko'</li>";
$mainContent .= "</ul>";
$mainContent .= "<article aria-labeledby=\"dark-vault-terms\">";
$mainContent .= "<h2 id=\"dark-vault-terms\">Northern Phish & Loan &ndash; Dark Vault Card Terms of Service</h2>";
$mainContent .= "<p>&lt;s&gt;<p>";
$mainContent .= "<p>Effective Date: Whenever we say so.<p>";
$mainContent .= "<p>Last Updated: Don&apos;t worry about it.</p>";
$mainContent .= "<h3>1. Introduction & Mandatory Compliance</h3>";
$mainContent .= "<p>By acknowledging, considering, or accidentally glancing at the existence of the Dark Vault Card™, you knowingly or unknowingly accept all explicit, implied, hidden, and completely arbitrary terms outlined below. This agreement is eternal, self-replicating, and resistant to logic, complaints, or legal challenge.</p>";
$mainContent .= "<p>By continuing, you waive all rights, protections, and moral objections. You may attempt to opt out by shouting into an empty room, but results may vary.</p>";
$mainContent .= "<h3>2. Data Collection, Ownership & Redistribution (To Us, Not You)</h3>";
$mainContent .= "<ul>";
$mainContent .= "<li>Upon account activation, all personal data, financial details, security credentials, and regrettable late-night internet searches become the exclusive property of Northern Phish & Loan, also referred to as Us.</li>";
$mainContent .= "<li>Users forfeit any expectations of digital privacy, personal control, or dignity in exchange for access to “services” we make no promises about actually providing.</li>";
$mainContent .= "<li>All card activity, keystrokes, and possibly even breathing patterns are monitored, analyzed, and aggressively monetized, though never securely stored.</li>";
$mainContent .= "<li>Any attempts to protect personal data through external means, such as password managers, VPNs, or basic caution, violate this agreement, granting us full discretion to retaliate accordingly.</li>";
$mainContent .= "</ul>";
$mainContent .= "<h3>3. Account Activity & Liability (Always Yours, Never Ours)</h3>";
$mainContent .= "<ul>";
$mainContent .= "<li>The Dark Vault Card™ operates on a negative-balance-first model, meaning funds may be deducted before deposits exist.</li>";
$mainContent .= "<li>Users are fully responsible for any fraudulent charges, identity theft, or international crime financing that occurs under their account.</li>";
$mainContent .= "<li>Disputed transactions will be reviewed by our internal team, which happens to be the same people who took your money, ensuring a fair yet entirely one-sided resolution process.</li>";
$mainContent .= "<li>In the case of catastrophic financial loss, Northern Phish & Loan reserves the right to distance itself completely while enjoying a good laugh.</li>";
$mainContent .= "</ul>";
$mainContent .= "<h3>4. Security Measures (Or Lack Thereof)</h3>";
$mainContent .= "We pride ourselves on world-class Security™, featuring:";
$mainContent .= "<ul>";
$mainContent .= "<li>Multi-Factor Authentication (MFA): A single, random emoji of our choosing.</li>";
$mainContent .= "<li>End-to-End Encryption: Decrypted and sold at our earliest convenience.</li>";
$mainContent .= "<li>Firewall Protection: Occasionally turned on when regulators are paying attention.</li>";
$mainContent .= "<li>Biometric Security: Fingerprint data collected strictly for resale purposes.</li>";
$mainContent .= "</ul>";
$mainContent .= "Users are strongly discouraged from reporting security incidents, as doing so immediately voids any remaining liability coverage.";
$mainContent .= "<h3>5. Account Termination & Non-Revocation Clause</h3>";
$mainContent .= "<ul>";
$mainContent .= "<li>Northern Phish & Loan reserves the absolute right to suspend, manipulate, seize, or exploit any account at any time, for any reason, or just for fun.</li>";
$mainContent .= "<li>Users may not close their accounts without written permission, which will not be granted.</li>";
$mainContent .= "<li>Attempting to close an account grants us the right to retain access to user data indefinitely, impose an Account Closure Fee equal to 300% of all previously held funds, and list personal details on various Dark Web platforms.</li>";
$mainContent .= "</ul>";
$mainContent .= "<h3>6. Dispute Resolution & Legal Maneuvering</h3>";
$mainContent .= "<ul>";
$mainContent .= "<li>All legal disputes must be resolved through Mandatory Arbitration, conducted by someone we know who owes us a favor.</li>";
$mainContent .= "<li>This contract overrides all national, international, and interdimensional laws, ensuring maximum enforceability wherever the user happens to exist.</li>";
$mainContent .= "<li>By proceeding, users waive the right to legal counsel, class-action lawsuits, and any expectation of fair treatment.</li>";
$mainContent .= "</ul>";
$mainContent .= "<h3>7. Final Statement of Authority</h3>";
$mainContent .= "<p>By choosing the Dark Vault Card™, users acknowledge that Northern Phish & Loan is, in all possible circumstances, legally unaccountable, financially untouchable, and morally absent.</p>";
$mainContent .= "<p>Click “Accept” to proceed. Or don’t. It doesn’t matter. We already have your data.</p>";
$mainContent .= "<input type=\"button\" style=\"background-color:#c41230; padding:10px; border-radius:10px; color:white;\"  onclick=\"clicked()\" value=\"Accept Terms\">";
$mainContent .= "<p>&lt;/s&gt;<p>";
$mainContent .= "</article>";
echo generatePage(singleColumnLayout($mainContent));
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
</script>
