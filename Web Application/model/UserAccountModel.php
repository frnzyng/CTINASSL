<?php 

class UserAccountModel {

    public static function registerUser($username, $password, $email) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare and execute a query to insert a new post
            $stmt = $db->prepare("INSERT INTO tblUserAccounts (username, password, email) VALUES (:username, :password, :email)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            // Execute the query
            $result = $stmt->execute();
            
            if ($result) {
                return true;
            } else {
                return false;
            }
            // Return the result
            //return $result;
        } catch (PDOException $e) {
            // Handle PDO exceptions
            echo "PDO Exception: " . $e->getMessage();
        } finally {
            // Close the database connection
            $db = null;
        }
    }  

    public static function updateUsername($account_id, $new_username, $password) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare and execute a query to select user by account_id
            $stmt1 = $db->prepare("SELECT account_id, username, password FROM tblUserAccounts WHERE account_id = :account_id");
            $stmt1->bindParam(':account_id', $account_id);
            $stmt1->execute();
    
            $user = $stmt1->fetch(PDO::FETCH_ASSOC);
    
            // Check if a user with the given account_id exists
            if ($user) {
                // Verify the password
                if (password_verify($password, $user["password"])) {
                    // Prepare and execute a query to update username
                    $stmt = $db->prepare("UPDATE tblUserAccounts SET username = :new_username WHERE account_id = :account_id");
                    $stmt->bindParam(':new_username', $new_username);
                    $stmt->bindParam(':account_id', $account_id);
                    // Execute the query
                    $result = $stmt->execute();
    
                    return $result;
                }
            }
        } catch (PDOException $e) {
            // Handle PDO exceptions
            echo "PDO Exception: " . $e->getMessage();
        } finally {
            // Close the database connection
            $db = null;
        }
    }    

    public static function updateUserEmail($account_id, $new_email, $password) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $stmt1 = $db->prepare("SELECT account_id, username, password FROM tblUserAccounts WHERE account_id = :account_id");
            $stmt1->bindParam(':account_id', $account_id);
            $stmt1->execute();

            $user = $stmt1->fetch(PDO::FETCH_ASSOC);

            // Check if a user with the given username exists
            if ($user) {
                // Verify the password
                if (password_verify($password, $user["password"])) {
                    // Prepare and execute a query to update email
                    $stmt = $db->prepare("UPDATE tblUserAccounts SET email = :new_email WHERE account_id = :account_id");
                    $stmt->bindParam(':new_email', $new_email);
                    $stmt->bindParam(':account_id', $account_id);
                    // Execute the query
                    $result = $stmt->execute();
                    
                    return $result;
                }
            }

        } catch (PDOException $e) {
            // Handle PDO exceptions
            echo "PDO Exception: " . $e->getMessage();
        } finally {
            // Close the database connection
            $db = null;
        }
    }  
}
?>