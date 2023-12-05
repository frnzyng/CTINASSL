<?php
class UserAuthModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function authenticateUser($username, $password) {
        // Prepare and execute a query to retrieve user data
        $stmt = $this->db->prepare("SELECT id, username, password FROM tblUserAccounts WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a user with the given username exists
        if ($user) {
            // Verify the password
            if (password_verify($password, $user["password"])) {
                // Authentication successful
                return $user;
            }
        }

        // Authentication failed
        return false;
    }
}
?>