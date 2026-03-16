<?php
/*
    layout.php
    Simple HTML layouts.
*/

function presentationalWrapper(string $content) {
    return "<div role=\"presentation\">$content</div>";
}

/**
 * Wraps the supplied HTML with a div having class `single-column`.
 */
function singleColumnLayout(string $content) {
    return "<div class=\"single-column\" role=\"presentation\">$content</div>";
}
/**
 * Wraps the supplied HTML with a div having class `two-column`.
 */
function twoColumnLayout(string $left, string $right) {
    return "<div class=\"two-column\" role=\"presentation\">$left$right</div>";
}

/**
 * Wraps the supplied HTML with a div having class `three-column`.
 */
function threeColumnLayout(string $left, string $center, string $right) {
    return "<div class=\"three-column\" role=\"presentation\">$left$center$right</div>";
}

/**
 * Returns HTML markup for a banner with a title and subtitle.
 */
function createBanner(string $title, string $subtitle, string $backgroundImageUrl): string {
    
    $html = "<div id=\"banner\" role=\"presentation\">";
    $html .= "<hgroup>";
    $html .= "<h1>$title</h1>";
    if($subtitle) {
        $html .= "<p>$subtitle</p>";
    }
    $html .= "</hgroup>";
    $html .= "<img src=\"$backgroundImageUrl\" role=\"presentation\" alt=\"\" fetchpriority=\"high\">";
    $html .= "</div>";

    return $html;
}

/**
 * Returns HTML for a newsletter article.
 * @param string $title
 * @param Date $date
 * @param string $content
 * @return string
 */
function createNewsletterArticle(string $title, DateTime $date, string $content) {

    $html = "";
    $html .= "<article class=\"h-entry\">";
    $html .= "<hgroup>";
    $html .= "<h3 class=\"p-name\">$title</h3>";
    $dateIso = date_format($date, "Y-m-d");
    $dateUsa = date_format($date, "F jS, Y");
    $html .= "<p><time datetime=\"$dateIso\">$dateUsa</time></p>";
    $html .= "</hgroup>";
    $html .= "<div class=\"e-content\">$content</div>";
    $html .= "</article>";

    return $html;
}

/**
 * Returns HTML an entry in the "our team" section.
 */
function createOurTeamEntry(string $name, string $position, string $phoneNumber, int|null $phoneNumberExt=null, string $email=null, string|null $portraitUrl=null) {

    $html = "";
    $html .= "<tr class=\"vcard\">";
    $html .= "<td><a href=\"team_info.php\" ><img class=\"photo\" src=\"$portraitUrl\" alt=\"portrait of $name\"></a></td>";
    $html .= "<td style=\"padding:.5em\" class=\"fn\">$name</td>";
    $html .= "<td>$position</td>";
    $html .= "<td  style=\"padding:.5em\" class=\"tel\"><a href=\"tel:$phoneNumber;ext=301\">$phoneNumber <abbr>Ext. $phoneNumberExt</abbr></a></td>";
    $html .= "</tr>";

    return $html;
}