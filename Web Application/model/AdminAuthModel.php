<?php
class AdminAuthModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function authenticateAdmin($username, $password) {
        // Prepare and execute a query to retrieve user data
        $stmtAuthenticate = $this->db->prepare("SELECT account_id, username, password FROM tblAdminAccounts WHERE username = :username");
        $stmtAuthenticate->bindParam(':username', $username);
        $stmtAuthenticate->execute();

        // Fetches the row from the result set
        $adminAccount = $stmtAuthenticate->fetch(PDO::FETCH_ASSOC);

        // Check if the admin account exists
        if ($adminAccount) {
            // Verify the password of the account
            if (password_verify($password, $adminAccount["password"])) {
                // Authentication successful
                return $adminAccount;
            }
        }

        // Authentication failed
        return false;
    }
}
?>