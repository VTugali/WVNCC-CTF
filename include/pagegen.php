<?php
/*
    pagegen.php
    Code for generating the markup that appears on all pages.
*/

include "/var/www/html/include/search.php";

/**
 * Returns HTML that links to the list of stylesheets provided.
 * @param array $stylesheetLocations URLs or file paths to CSS stylesheets, as an array of strings.
 * @return string String of HTML &lt;link&gt; elements that load the stylesheets specified.
 */
function createStylesheetLinks(array $stylesheetLocations): string {

    $result = "";
    foreach($stylesheetLocations as $location) {
        $result .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$location\">";
    }
    return $result;
}

/**
 * Returns HTML for the &lt;head&gt; element.
 * @return string The head element.
 */
function createHeadElement(): string {

    $result = "";
    $result .= "<head>";
    $result .= "<meta charset=\"utf-8\">";
    $result .= "<meta name=\"author\" content=\"West Virginia Northern Community College, Department of Computer Information Technology\">";
    $result .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">";
    $result .= createStylesheetLinks(array(
        "/css/style.css",
        "/css/header.css",
        "/css/footer.css",
        "/css/home.css",
        "/css/banner.css",
        "/css/simpleform.css",
        "/css/dashboard.css",
        "/css/account.css",
        "/css/meet-our-team.css",
        "/css/media-queries.css",
        "/css/important.css"
    ));
    $result .= "<link rel=\"icon\" type=\"img/x-icon\" href=\"/img/logo_small.webp\">";
    $result .= "<script src=\"/js/script.js\"></script>";
    $result .= "<title>Northern Phish &amp; Loan</title>";
    $result .= "</head>";
    return $result;
}

/**
 * Returns HTML for the &lt;header&gt; element.
 * @return string The header element.
 */
function createHeaderElement(): string {

    $result = "";
    $result .= "<header>";
    $result .= "<a id=\"skip-link\" href=\"#main\">Skip to content</a>";
    $result .= "<nav id=\"primary-navigation\" aria-label=\"Site\">";
    $result .= "<ul>";
    $result .= "<li><a href=\"/\"><img srcset=\"/img/logo_small.webp, /img/logo_large.webp 3x\" alt=\"Home\" width=\"232\" height=\"64\" fetchpriority=\"high\"></a></li>";
    if(isLoggedIn()) {
        //gets the logged in user, their account info, and sets the "isAdmin" field's true/false to the admin check variable
        $user = getCurrentUser();
        $adminCheck = $user->isAdmin;
        $result .= "<li><button id=\"online-banking-menu-button\" type=\"button\" aria-expanded=\"false\" aria-controls=\"online-banking-dropdown\">Online Banking</button>";
        $result .= "<ul id=\"online-banking-dropdown\" hidden>";
        $result .= "<li><a href=\"/banking/dashboard.php\">Dashboard</a></li>";
        $result .= "<li><a href=\"/banking/mobile-deposit.php\">Mobile deposit</a></li>";
        $result .= "<li><a href=\"/banking/transfer.php\">Funds transfer</a></li>";
        $result .= "<li><a href=\"/banking/loanApplication.php\">Apply For Loan</a></li>";
        $result .= "<li><a href=\"/banking/change-password.php\">Change Password</a></li>";
        $result .= "<li><a href=\"/banking/logout.php\">Log Out</a></li>";
        $result .= "</ul>";
        $result .= "</li>";
        //link to the admin page only appears if the logged in user's "isAdmin" field = true
        if ($adminCheck == true) {
            $result .= "<li><a href=\"/admin.php\">Admin</a></li>";
        }
    } else {
        $result .= "<li><a href=\"/banking/login.php\">Login</a></li>";
        $result .= "<li><a href=\"/banking/register.php\">Register</a></li>";
    }
    $result .= "<li><a href=\"/feedback.php\">Feedback</a></li>";
    $result .= "<li><button id=\"about-menu-button\" type=\"button\" aria-expanded=\"false\" aria-controls=\"about-dropdown\">About</button>";
    $result .= "<ul id=\"about-dropdown\" hidden>";
    $result .= "<li><a href=\"/about/our-team.php\">Our team</a></li>";
    $result .= "<li><a href=\"/about/locations.php\">Locations</a></li>";
    $result .= "<li><a href=\"/about/legal.php\">Legal</a></li>";
    $result .= "<li><a href=\"/about/chat_support.php\">Chat Support</a></li>";
    $result .= "</ul>";
    $result .= "</li>";
    $result .= "</ul>";
    $result .= "</nav>";
    $searchIcon = "<svg id=\"fsa_HeaderButtonWebSearchToggle\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><path d=\"M508.5 481.6l-129-129c-2.3-2.3-5.3-3.5-8.5-3.5h-10.3C395 312 416 262.5 416 208 416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c54.5 0 104-21 141.1-55.2V371c0 3.2 1.3 6.2 3.5 8.5l129 129c4.7 4.7 12.3 4.7 17 0l9.9-9.9c4.7-4.7 4.7-12.3 0-17zM208 384c-97.3 0-176-78.7-176-176S110.7 32 208 32s176 78.7 176 176-78.7 176-176 176z\"></path></svg>";
    $result .= "<form role=\"search\" method=\"GET\" action=\"/search.php\">";
    $result .= "<datalist id=\"search-terms-datalist\">";
    foreach(getAllKeywords() as $term) {
        $result .= "<option>$term</option>";
    }
    $result .= "</datalist>";
    $result .= "<!--TODO: Ensure that the user isn't typing any HTML code here-->";
    $result .= "<input id=\"query-field\" type=\"search\" name=\"query\"  list=\"search-terms-datalist\" required aria-labelledby=\"search-button\" title=\"Search site by keyword\" placeholder=\"Search keywords\">";
    $result .= "<button id=\"search-button\" type=\"submit\" aria-label=\"Search\">$searchIcon</button>";
    $result .= "</form>";
    $result .= "</header>";
    return $result;
}

/**
 * Generates headers, footers, and all of that good stuff. Pass it HTML to place in the &lt;main&gt; element, and it returns an entire page to be <code>echo</code>'d
 * @param string $mainContent HTML markup that will be placed inside of the &lt;main&gt; element.
 * @return string HTML string for an entire page of the site.
 */
function generatePage(string $mainContent): string {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    $result = "<!DOCTYPE html><html lang=\"en\">";
    $result .= createHeadElement();
    $result .= "<body>";
    $result .= "<!-- TODO: --><!-- Prevent users from putting JavaScript code in the search form --><!-- Figure out why SQL errors happen when a username contains a quote --><!-- Check file types that are uploaded to the site -->";
    $result .= createHeaderElement();
    $result .= "<main id=\"main\">$mainContent</main>";
    $result .= "<footer>";
    $footerLeft = "";
    $footerLeft .= "<h2>Legal</h2>";
    $footerLeft .= "<p>Northern Phish &amp; Loan, member FDIC.</p>";
    $footerLeft .= "<p>ADA NOTICE: This site meets or exceeds <abbr title=\"Web Content Accessibility Guidlines version 2.1\">WCAG 2.1</abbr>. Trust us, we <em>totally</em> checked.</p>";
    $footerLeft .= "<p>Diversity, Equity, Inclusion, and Accessibility</p>";
    $footerLeft .= "<p><a href=\"/about/legal.php#dark-vault-terms\">Dark Vault Credit terms of service</a></p>";
    $footerLeft .= "<p><a href=\"/about/legal.php#attribution\">Attributions</a></p>";
    $footerMiddle = "";
    $footerMiddle .= "<h2>Locations</h2>";
    $footerMiddle .= "<ul>";
    $footerMiddle .= "<li><a href=\"/about/locations.php\">Weirton</a></li>";
    $footerMiddle .= "<li><a href=\"/about/locations.php\">Wheeling</a></li>";
    $footerMiddle .= "<li><a href=\"/about/locations.php\">New Martinsville</a></li>";
    $footerMiddle .= "</ul>";
    $footerRight = "";
    $footerRight .= "<h2>Quick Links</h2>";
    $footerRight .= "<nav><ul>";
    $footerRight .= "<li><a href=\"/banking/login.php\">Login</a></li>";
    $footerRight .= "<li><a href=\"/banking/loanApplication.php\">Loan Application</a></li>";
    $footerRight .= "<li><a href=\"/feedback.php\">Contact</a></li>";
    $footerRight .= "<li><a href=\"/about/our-team.php\">Our Team</a></li>";
    $footerRight .= "<li><a title=\"lol nope\">Careers</a></li>";
    $footerRight .= "</ul></nav>";
    $result .= threeColumnLayout(presentationalWrapper($footerLeft), presentationalWrapper($footerMiddle), presentationalWrapper($footerRight));
    $result .= "<hr>";
    $realDisclamer = "";
    $realDisclamer .= "<p>This site is for educational purposes only and does not provide financial services.</p>";
    $realDisclamer .= "<p>Copyright © 2025 West Virginia Northern Community College, Department of Computer Information Technology.</p>";
    $result .= singleColumnLayout($realDisclamer);
    $result .= "</footer>";
    $result .= "</body>";
    $result .= "</html>";
    return $result;
}
