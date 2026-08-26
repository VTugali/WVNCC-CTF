<?php
/*
    accountcard.php
    Generates the account preview card in the dashboard and account page.
*/
include "/var/www/html/include/bankaccount.php";
include "/var/www/html/banking/bankingFunctions.php";
/**
 * Generates an HTML element that shows information about a bank account.
 * @param BankAccount $account The account to show.
 * @param mixed $currentBalance The current balance on the account, in dollars.
 * @param bool $isLink Whether or not to make the element a link to the account.
 * @return string
 */
function generateAccountCard(BankAccount $account, $currentBalance, bool $isLink): string {
    $html = "";
    $dollars = floor($currentBalance);
    $cents = floor($currentBalance * 100) % 100;
    if(strlen("".$cents) < 2) {
        $cents = "0".$cents;
    }

    $accountName = perhapsSanitizeAgainstXss($account->nickname, XssType::STORED);
    $accountNumber = $account->accountNumber;
    $accountType = $account->accountType->toString();

    // These 2 lines get the the user id and the account balances by account type and
    // user id using the function getAccountBalance() in the bankingFunctions.php page
    $userId = $_COOKIE["logged-in-user"];
    $balance = getAccountBalance($accountType,$userId);

    $icon = '<svg alt="" role="presentation" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 256 256" enable-background="new 0 0 256 256" xml:space="preserve">
            <metadata> Svg Vector Icons : http://www.onlinewebfonts.com/icon </metadata>
            <g><g><g><path d="M69,39.7L10.2,69.2H128h117.8L187,39.7c-32.3-16.2-58.9-29.5-59-29.5S101.3,23.5,69,39.7z M155.3,43.4c14.4,6.4,26.1,11.7,26,11.8c-0.1,0.1-12.1-2.5-26.7-5.8L128,43.4l-26.6,5.9c-14.7,3.2-26.7,5.9-26.8,5.8c-0.3-0.3,52.8-23.7,53.6-23.6C128.7,31.7,141,37,155.3,43.4z"/><path d="M10,86v8.5h118h118V86v-8.5H128H10V86z"/><path d="M22.6,103.5c-0.1,0.3-0.1,3.2-0.1,6.4l0.1,5.7l4.3,0.1l4.2,0.1v46.3v46.3l12.6-0.1l12.5-0.1l0.1-46.2l0.1-46.2l4.1-0.1l4-0.1l0.1-6.4l0.1-6.3h-21C27,102.9,22.8,103,22.6,103.5z"/><path d="M77.4,109.2l0.1,6.4l4.3,0.1l4.2,0.1v46.3v46.3h12.4h12.4v-46.3v-46.3l4.3-0.1l4.2-0.1l0.1-6.4l0.1-6.3H98.5H77.3L77.4,109.2z"/><path d="M136.4,109.2l0.1,6.4l4.3,0.1l4.2,0.1v46.3v46.3h12.4h12.4v-46.3v-46.3l4.3-0.1l4.2-0.1l0.1-6.4l0.1-6.3h-21.2h-21.3L136.4,109.2z"/><path d="M191.2,109.2l0.1,6.4l4,0.1l4.1,0.1l0.1,46.2l0.1,46.2l12.6,0.1l12.5,0.1v-46.3v-46.3l4.3-0.1l4.2-0.1v-6.2v-6.2l-21.1-0.1l-21.1-0.1L191.2,109.2z"/><path d="M18.3,216.7v4.1H128h109.7v-4.1v-4.1H128H18.3V216.7z"/><path d="M10,237.5v8.3h118h118v-8.3v-8.3H128H10V237.5z"/></g></g></g>
            </svg>';
    $label = "$accountName account, $accountType number ".implode("", str_split($accountNumber)).". $dollars dollars and $cents cents , current balance.";
    $accountNameAndNumberSection = "<div class=\"account-name-and-number-section\">$icon<div class=\"account-type-section\"><p class=\"account-name\">$accountName account</p><p>$accountType #$accountNumber</p></div></div>";
    $accountBalanceSection = "<div class=\"account-balance-section\"><p class=\"account-balance\">$$balance</p><p>Current balance</p></div>";
    if($isLink) {
        $html .= "<a class=\"account-card\" href=\"/banking/account.php?account-number=$accountNumber\" aria-label=\"$label\">$accountNameAndNumberSection$accountBalanceSection</a>";
    } else {
        $html .= "<section class=\"account-card\" aria-label=\"Account summary\">$accountNameAndNumberSection$accountBalanceSection</section>";
    }
    return $html;
}

/**
 * Iterates though the accounts, calls `generateAccountCard`, and concats the results. This function is used on the dashboard.
 * @param array $accounts
 * @param bool $createHyperlinks Whether or not the elements link to thier respective account pages.
 * @return string
 */
function generateAccountCards(array $accounts, bool $createHyperlinks) {
    $html = "";
    foreach($accounts as $account) {
        $html .= generateAccountCard($account, 0, $createHyperlinks);
    }
    return $html;
}
