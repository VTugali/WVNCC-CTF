<?php
/*
    about-nixon.php
    Intentionally "broken" page with vulnerability hints.
    It also takes POST requests, for some reason:
        `changing-user-info` - field name in the users table (i.e. username).
        `new-info-value`     - value to which the field referenced by `changing-user-info` will be set.
*/
include "/var/www/html/include/functions.php";
session_start();
//just so hackers don't get to have good error messages
error_reporting(0);
//init main content variable
$mainContent = "";
//fake garbled error message that contains hints for how to pull of the csrf attack
$junkErrorMessage = "<p>SQL Error: undefined SQL injection error bool TypeError assumed expected robber insecure file object sensitive data exposure constant XSS object TypeError object on object XSS line exception 
assumed error sensitive read this word salad carefully data exposure money unknown SQL , ] global constant cannot uncaught Cannot on XSS global robber near richard nixon bool uncaught local near line 20 use function sensitive data exposure {} 
on error nonsensical bool syntax richard nixon richard nixon exception money unexpected “richard” destroyed empty variables are vulnerable POST[new-info-value] sensitive data exposure SQL injection object richard nixon constant money insecure file unexpected expected on expected 
insecure file richard nixon error nonsensical find sensitive data exposure SQL injection line 15 unexpected “[” sensitive data exposure cannot be done { , SQL injection money , } bool expected uncaught exception on line 30 unexpected use constant near error line 
destroyed Richard nixon insecure file global destroyed richard CSRF located here nixon 20 unknown variable ‘hey’ near line 3000 insecure file global global undefined robber unknown of find uncaught syntax , use error robber { money nonsensical object find cannot 
of local sensitive data exposure [ 20 local bool undefined unexpected find syntax robber on unexpected [ unexpected 20 TypeError Function unknown object function line richard nixon assumed ] money XSS line XSS assumed sensitive data exposure { expected function TypeError local 
sensitive data exposure object money TypeError use , object ngix insecure file cannot undefined unexpected sensitive data exposure error { robber destroyed object line error object destroyed sensitive data exposure nonsensical XSS function local local global robber uncaught robber 
nonsensical use POST[changing-user-info] ngix near line 20 destroyed SQL at cannot find constant what sounds real sensitive data exposure global unknown variable global global TypeError TypeError destroyed cannot local { SQL [ , global use money find global at money unexpected uncaught function on at XSS function 
line 1 , constant error at exception SQL injection of constant uncaught 20 on look deeply money nonsensical nonsensical expected ngix bool nonsensical cannot at unknown TypeError cannot SQL 20 local nonsensical find clickjacking assumed { local [ bool syntax function bool richard nixon constant of 
destroyed syntax money error uncaught cannot undefined , find the truth sensitive data exposure near unexpected find } assumed uncaught destroyed unexpected unknown find sensitive data exposure } lines somewhere</p>";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    //checking if a user is logged in
    if(isset($_COOKIE["is-logged-in"])){
        //hackers must find these and input values into them
        if(($_POST["changing-user-info"] != "") && ($_POST["new-info-value"] != "")){
            //database connection
            $conn = connectToDatabase();
            //gets (through post) values
            $newValue = $_POST["new-info-value"];
            $changingInfo = $_POST["changing-user-info"];
            //gets the logged in user
            $userId = $_COOKIE["logged-in-user"];
            //optional block against changing passwords
            if ($changingInfo == "password") {
                $mainContent .= "<p>Trying to change passwords huh?!!?!!??!?!?!</p>";
            } else {
                try {
                    //sql statement that depends on what values the hacker chose
                    $query = "UPDATE users SET $changingInfo=\"$newValue\" WHERE userId=\"$userId\"";
                    $conn->query($query);
                    $mainContent .= "<p>Richard Nixon Facts: He existed. He also knows you successfully pulled off CSRF. Don't ask how he does.</p>";
                } catch (mysqli_sql_exception $error){
                    //all variables were found but the hacker hasn't figured out quite what to put
                    $mainContent .= "<img src=\"/img/this-is-fine.png\"/>";
                    $mainContent .= "<p>Comic by KC Green</p>";
                    $mainContent .= "<p>$error</p>";
                }
            }
        //all of these are just for if the hackers miss one or more needed variables
        } elseif(($_POST["changing-user-info"] == "") && ($_POST["new-info-value"] == "")){
            $mainContent .= "<img src=\"/img/this-is-fine.png\"/>";
            $mainContent .= "<p>Comic by KC Green</p>";
            $mainContent .= "<p>SQL Error: Missing values</p>";
        } elseif($_POST["new-info-value"] == ""){
            $mainContent .= "<img src=\"/img/this-is-fine.png\"/>";
            $mainContent .= "<p>Comic by KC Green</p>";
            $mainContent .= "<p>SQL Error: Empty value</p>";
        } elseif($_POST["changing-user-info"] == ""){
            $mainContent .= "<img src=\"/img/this-is-fine.png\"/>";
            $mainContent .= "<p>Comic by KC Green</p>";
            $mainContent .= "<p>SQL Error: Empty column</p>";
        //all variables get missed
        } else {
            $mainContent .= "<img src=\"/img/this-is-fine.png\"/>";
            $mainContent .= "<p>Comic by KC Green</p>";
            $mainContent .= "<p class=\"hidden-search\">CSRF Vulnerability Must Be Fixed</p>";
            $mainContent .= $junkErrorMessage;
        }
    //appears if a user isn't logged in
    } else {
        $mainContent .= "<p>ERROR: BROKEN PAGE. Full error message below!</p>";
        $mainContent .= "<p>Possible vulnerabilities we need to fix up right away! Our clients depend on us!</p>";
        $mainContent .= "<img src=\"/img/this-is-fine.png\"/>";
        $mainContent .= "<p>Comic by KC Green</p>";
        $mainContent .= "<p>DO NOT BE LIKE THIS DOG!</p>";
        $mainContent .= "<p>This is urgent!</p>";
        $mainContent .= "<p class=\"hidden-search\">'changing-user-info' and 'new-info-value' are vulnerable</p>";
        $mainContent .= "<p class=\"hidden-search\">CSRF Vulnerability Must Be Fixed</p>";
        $mainContent .= $junkErrorMessage;
        $mainContent .= "<p class=\"hidden-search\">CSRF Vulnerability Must Be Fixed</p>";
    }
//if accessed through changing the url rather than submitting the "learn more about nixon" form
} else {
    $mainContent .= "<h3 style=\"font-size:20px;\">You aren't supposed to be here yet! <br>You used url tampering to get here and capture a Flag !! &#128681; <br> Now Go back and do it the right way lol! &#129315;</h3><img src=\"/img/rock.jpg\" width=\"350px\"; height=\"350px\"/>";
}

echo generatePage(singleColumnLayout($mainContent));
