<?php
class UserAuthModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function authenticateUser($username, $password) {
        // Prepare and execute a query to authenticate user account
        $stmtAuthenticate = $this->db->prepare("SELECT account_id, username, password FROM tblUserAccounts WHERE username = :username");
        $stmtAuthenticate->bindParam(':username', $username);
        $stmtAuthenticate->execute();

        // Fetches the row from the result set
        $userAccount = $stmtAuthenticate->fetch(PDO::FETCH_ASSOC);

        // Check if the user account exists
        if ($userAccount) {
            // Verify the password of the account
            if (password_verify($password, $userAccount["password"])) {
                // Authentication successful
                return $userAccount;
            }
        }

        // Authentication failed
        return false;
    }
}
?>