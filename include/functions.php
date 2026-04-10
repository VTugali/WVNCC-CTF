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
 