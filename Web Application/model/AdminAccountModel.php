<?php

class AdminAccountModel {
    public static function recordActivityLog($admin_account_id, $action, $ip_address) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmtAuthenticate = $db->prepare("SELECT account_id, username, password FROM tblAdminAccounts WHERE account_id = :account_id");
            $stmtAuthenticate->bindParam(':account_id', $admin_account_id);
            $stmtAuthenticate->execute();

            // Fetches the row from the result set
            $adminAccount = $stmtAuthenticate->fetch(PDO::FETCH_ASSOC);
            // Get the account username
            $username = $adminAccount['username'];

            // Prepare and execute a query to record user log
            $stmtRecordLog = $db->prepare("INSERT INTO tblAdminActivityLog (account_id, username, action, datetime, ip_address) VALUES (:account_id, :username, :action, NOW(), :ip_address)");
            $stmtRecordLog->bindParam(':account_id', $admin_account_id);
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
            $db = null;
        }
    }
}