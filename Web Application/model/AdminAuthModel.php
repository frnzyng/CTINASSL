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

    public function recordAdminLog($account_id, $action, $ip_address) {
        try {
            $stmtAuthenticate = $this->db->prepare("SELECT account_id, username, password FROM tblAdminAccounts WHERE account_id = :account_id");
            $stmtAuthenticate->bindParam(':account_id', $account_id);
            $stmtAuthenticate->execute();

            // Fetches the row from the result set
            $userAccount = $stmtAuthenticate->fetch(PDO::FETCH_ASSOC);
            // Get the account username
            $username = $userAccount['username'];

            // Prepare and execute a query to record user log
            $stmtRecordLog = $this->db->prepare("INSERT INTO tblAdminLog (account_id, username, action, datetime, ip_address) VALUES (:account_id, :username, :action, NOW(), :ip_address)");
            $stmtRecordLog->bindParam(':account_id', $account_id);
            $stmtRecordLog->bindParam(':username', $username);
            $stmtRecordLog->bindParam(':action', $action);
            $stmtRecordLog->bindParam(':ip_address', $ip_address);
            // Execute the query
            $result = $stmtRecordLog->execute();
            
            // Returns 1 if true, 0 if false
            return $result;
            
        } 
        catch (PDOException $e) {
            // Handle PDO exceptions
            echo "PDO Exception: " . $e->getMessage();
        } 
        finally {
            // Close the database connection
            $this->db = null;
        }
    }
}
?>