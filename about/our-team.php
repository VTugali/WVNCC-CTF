<?php
/*
    our-team.php
    Static page with information about our staff.
*/
session_start();
include "/var/www/html/include/functions.php";

$mainContent = "";
$banner = createBanner("Our Team", "", "/img/bank.webp");
$mainContent .= "<table id=\"meet-our-team\">";
$mainContent .= "<tbody>";
$mainContent .= createOurTeamEntry("Angela Ackermann", "Director of Threatening SLAPP Lawsuits", "304-555-1234", 301, "angela_ackermann@northernphish.com", "/img/profile/web/angela-bio-img.webp");
$mainContent .= createOurTeamEntry("Grant Kent", "Director of Incompliance", "304-555-1234", 501, "grant_kent@northernphish.com", "/img/profile/web/grant-bio-img.webp");
$mainContent .= createOurTeamEntry("Josephine Poulin", "Vice President of Elaborate Documentation and Auditing", "304-555-5555", 505, "josephine_poulin@northernphish.com", "/img/profile/web/josie-bio-img.webp");
$mainContent .= createOurTeamEntry("Sean Lauritzen II", "Associate Director of Operational Strategy Management", "304-555-5555", 302, "sean_lauritzen@northernphish.com", "/img/profile/web/sean-bio-img.webp");
$mainContent .= createOurTeamEntry("Kevin Hoge", "Chief Operator of Perimeter Doorknobs", "304-555-1234", 304, "kevin_hoge@northernphish.com", "/img/profile/web/kevin-bio-img.webp");
$mainContent .= createOurTeamEntry("Vikram-sensei", "CISO (Chief Instinctive Security Overlord)", "304-555-1234", "807", "vickram_tugali@northernphish.com", "/img/profile/web/vickram-bio-img.webp");
$mainContent .= createOurTeamEntry("Wyatt McNeil", "Chancellor of High Interest Loans", "304-555-1234", 117, "wyatt_mcneil@northernphish.com", "/img/profile/web/wyatt-bio-img.webp");

$mainContent .= createOurTeamEntry("Charlyn Woodruff","Full Stack Ninjaneer of Banking & Loan Chaos", "304-555-7373", 735, "charlyn_woodruff@northernphish.com", "/img/profile/web/charlyn-bio-img.webp");
$mainContent .= createOurTeamEntry("Ty Patterson","Director of Penny Counting Department ", "304-555-8282", 801, "ty_patterson@northernphish.com", "/img/profile/web/ty-bio-img.webp");
$mainContent .= createOurTeamEntry("Caleb Cunningham","Director of Strategic Button Pressing", "304-420-6767", 314, "caleb_cunningham@northernphish.com", "/img/profile/web/caleb-bio-img.webp");
$mainContent .= createOurTeamEntry("Liam Clements","Director of IT Mischief ", "304-555-2121", 721, "liam_clements@northernphish.com", "/img/profile/web/liam-bio-img.webp");
$mainContent .= createOurTeamEntry("Luke Urso","Director of “Just Draft Mendoza” Campaign", "304-555-7575", 803, "luke_urso@northernphish.com", "/img/profile/web/luke-bio-img.webp");
$mainContent .= createOurTeamEntry("Frank Ciszek","Director  Lawsuits", "304-555-4884", 787, "frank_ciszek@northernphish.com", "/img/profile/web/frank-bio-img.webp");
$mainContent .= createOurTeamEntry("Joseph Nemuras","Manager of Forced Enthusiasm", "304-555-9393", 841, "joseph_nemuras@northernphish.com", "/img/profile/web/joseph-bio-img.webp");
$mainContent .= "</tbody>";
$mainContent .= "</table>";
// Removed the contact form for now; if it is not obsolesced
// by the feedback form it can be returned from the git history for later use
echo generatePage($banner . $mainContent);
