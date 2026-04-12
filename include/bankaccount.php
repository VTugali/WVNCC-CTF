<?php
/*
    bankaccount.php
    Code for representing and managing bank accounts in the DB.
*/

enum AccountType {
    case CHECKING;
    case SAVING;
    case DARK_VAULT_CREDIT;
    case MORGAGE;

    static function fromString(string $accountType) {
        
        $type = strtolower($accountType);
        if($type == "saving") {
            return AccountType::SAVING;
        } else if(str_contains($type, "dark vault credit")) {
            return AccountType::DARK_VAULT_CREDIT;
        } else if($type == "morgage") {
            return AccountType::MORGAGE;
        } else {
            // idk lol just give them a checking account
            return AccountType::CHECKING;
        }
    }
    function toString() {
        switch($this) {
            case AccountType::CHECKING: return "Checking";
            case AccountType::SAVING: return "Saving";
            case AccountType::DARK_VAULT_CREDIT: return "Dark Vault Credit";
            case AccountType::MORGAGE: return "Morgage";
        }
    }
}
class BankAccount {
    public int $accountNumber;
    public int $userId;
    public AccountType $accountType;
    public string $nickname;
    public function __construct(int $accountNumber, int $userId, AccountType $accountType, string $nickname) {
        $this->accountNumber = $accountNumber;
        $this->userId = $userId;
        $this->accountType = $accountType;
        $this->nickname = $nickname;
    }
    public static function fromAsocArray(array $accountObj): BankAccount {
        return new BankAccount(
            $accountObj["accountNumber"],
            $accountObj["userId"],
            AccountType::fromString($accountObj["accountType"]),
            $accountObj["nickname"],
        );
    }
}

function bankAccountFromAccountNumber(int $accountNumber) {
    global $isVulnerableToSqlInjection;
    $database = connectToDatabase();
    try {
        if($isVulnerableToSqlInjection) {
            return BankAccount::fromAsocArray($database->query("SELECT * FROM accounts WHERE accountNumber=$accountNumber")->fetch_assoc());
        } else {
            $query = $database->prepare("SELECT * FROM accounts WHERE accountnumber=?");
            $query->bind_param("i", $accountNumber);
            $query->execute();
            $queryResult = $query->get_result();
            if(is_bool($queryResult)) {
                return null;
            } else {
                return BankAccount::fromAsocArray($queryResult->fetch_assoc());
            }
        }
    } catch(mysqli_sql_exception $error) {
        return null;
    }
}

/**
 * Returns all of the bank accounts held by aparticular user.
 * @param int $userId User ID of accountholder.
 * @return array Array of BankAccout objects held by the user.
 */
function bankAccountsFromUser(int $userId) {
    global $isVulnerableToSqlInjection;
    $database = connectToDatabase();
    $accounts = array();
    try {
        if($isVulnerableToSqlInjection) {
            $q = $database->query("SELECT * FROM accounts WHERE userId=$userId");
            while($account = $q->fetch_assoc()) {
                array_push($accounts, BankAccount::fromAsocArray($account));
            }
        } else {
            $query = $database->prepare("SELECT * FROM accounts WHERE userId=?");
            $query->bind_param("i", $userId);
            $query->execute();
            $queryResult = $query->get_result();
            if(is_bool($queryResult)) {
                return array();
            } else {
                while($account = $queryResult->fetch_assoc()) {
                    array_push($accounts, $account);
                }
            }
        }
    } catch(mysqli_sql_exception $error) {
        return array();
    }
    return $accounts;
}

function insertAccountIntoDb(BankAccount $account) {
    
    $database = connectToDatabase();
    try {
        $query = $database->prepare("INSERT INTO accounts (userId, accountType, nickname) VALUES (?, ?, ?)");
        $accountType = $account->accountType->toString();
        $query->bind_param("iss",  $account->userId, $accountType, $account->nickname);
        $query->execute();
    } catch(mysqli_sql_exception $error) {
        echo $error->getMessage();
    }
}