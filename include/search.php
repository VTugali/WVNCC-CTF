<?php
/*
    include/search.php
    Code enabling the keyword search feature
*/
include "/var/www/html/include/vulnconfig.php";

$keyTerms = array(
    array("login", "log", "account", "sign"),
    array("create", "register", "sign", "account"),
    array("feedback", "comment", "complain", "forum", "contact", "message", "chat"),
    array("about", "history", "managment", "call", "contact", "number", "address","team", "nixon"),
    array("download", "app"),
    array("contract", "legal", "term", "arbitration", "privacy", "agreement"),
);
$resultingPages = array(
    array("/banking/login.php", "Log in to your account"),
    array("/banking/register.php", "Sign up for an account"),
    array("/feedback.php", "Tell us how we're doing"),
    array("/about/our-team.php", "About Northern Phish &amp; Loan"),
    array("https://play.google.com/store/apps/details?id=edu.wvncc.northernphish", "Download our app"),
    array("/about/legal.php", "Terms of Service")
);

/**
 * Gets all of the keywords to which the search feature responds.
 * @return array An array (list) of keyword strings.
 */
function getAllKeywords(): array {
    global $keyTerms;
    $result = array();
    foreach($keyTerms as $catagory) {
        $result = array_unique(array_merge($result, $catagory));
    }
    return $result;
}

/**
 * Returns HTML anchor tags relating to a supplied term.
 * @param string $keyword Keyword to search for.
 * @return array An array (list) of HTML anchor tags that link to resources relating to the search term. May be empty.
 */
function getAllLinksMatchingKeyword(string $keyword): array {
    global $keyTerms;
    global $resultingPages;
    $index = 0;
    $result = array();
    while($index < count($keyTerms)) {
        foreach($keyTerms[$index] as $term) {
            if(str_contains(strtolower($keyword), $term)) {
                $linkLocation = $resultingPages[$index][0];
                $anchorText = $resultingPages[$index][1];
                array_push($result, "<a href='$linkLocation'>$anchorText</a>");
            }
        }
        $index += 1;
    }

    return $result;
}