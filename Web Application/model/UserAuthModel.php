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
        $result = $stmtAuthenticate->fetch(PDO::FETCH_ASSOC);

        // Check if the user account exists
        if ($result) {
            // Verify the password of the account
            if (password_verify($password, $result["password"])) {
                // Authentication successful
                return $result;
            }
        }

        // Authentication failed
        return false;
    }
}
?>