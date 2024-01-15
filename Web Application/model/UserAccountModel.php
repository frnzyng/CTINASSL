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

            // Prepare query to check if username already exists
            $stmtUsernameExist = $db->prepare("SELECT username FROM tblUserAccounts WHERE username = :username");
            $stmtUsernameExist->bindParam(':username', $username);
            $stmtUsernameExist->execute();

            // Prepare query to check if email already exists
            $stmtEmailExist = $db->prepare("SELECT email FROM tblUserAccounts WHERE email = :email");
            $stmtEmailExist->bindParam(':email', $email);
            $stmtEmailExist->execute();

            // Verify if username and email already exists
            if ($stmtUsernameExist->rowCount() > 0) {
                return "Username already exists";
            }
            else if ($stmtEmailExist->rowCount() > 0) {
                return "Email already exists";
            }
            else {
                // Prepare and execute a query to insert a new post
                $stmtRegisterUser = $db->prepare("INSERT INTO tblUserAccounts (username, password, email) VALUES (:username, :password, :email)");
                $stmtRegisterUser->bindParam(':username', $username);
                $stmtRegisterUser->bindParam(':password', $password);
                $stmtRegisterUser->bindParam(':email', $email);
                // Execute the query
                $result = $stmtRegisterUser->execute();
                
                // Returns 1 if true, 0 if false
                return $result;
            }
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

    public static function updateAccountUsername($account_id, $new_username, $password) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare query to check if account with the given account id exists
            $stmtAccountExist = $db->prepare("SELECT account_id, username, password FROM tblUserAccounts WHERE account_id = :account_id");
            $stmtAccountExist->bindParam(':account_id', $account_id);
            $stmtAccountExist->execute();

            // Fetches the row from the result set
            $account = $stmtAccountExist->fetch(PDO::FETCH_ASSOC);

            // Verify account
            if ($account) {
                // Verify the password of the account
                if (password_verify($password, $account["password"])) {
                    // Prepare query to check if username already exists
                    $stmtUsernameExist = $db->prepare("SELECT username FROM tblUserAccounts WHERE username = :new_username");
                    $stmtUsernameExist->bindParam(':new_username', $new_username);
                    $stmtUsernameExist->execute();

                    // Verify if username already exists
                    if ($stmtUsernameExist->rowCount() > 0) {
                        return "Username already exists";
                    }
                    else {
                        // Prepare query to update username
                        $stmtUpdate = $db->prepare("UPDATE tblUserAccounts SET username = :new_username WHERE account_id = :account_id");
                        $stmtUpdate->bindParam(':new_username', $new_username);
                        $stmtUpdate->bindParam(':account_id', $account_id);

                        // Execute the query
                        $result = $stmtUpdate->execute();

                        // Returns 1 if true, 0 if false
                        return $result;
                    }
                }
                else {
                    return "Password is incorrect";
                }
            }
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
    
    public static function updateAccountEmail($account_id, $new_email, $password) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare query to check if account with the given account id exists
            $stmtAccountExist = $db->prepare("SELECT account_id, username, password FROM tblUserAccounts WHERE account_id = :account_id");
            $stmtAccountExist->bindParam(':account_id', $account_id);
            $stmtAccountExist->execute();

            // Fetches the row from the result set
            $account = $stmtAccountExist->fetch(PDO::FETCH_ASSOC);

            // Verify account
            if ($account) {
                // Verify the password of the account
                if (password_verify($password, $account["password"])) {
                    // Prepare query to check if user tries to use the same email
                    $stmtSameEmail = $db->prepare("SELECT email, account_id FROM tblUserAccounts WHERE email = :new_email AND account_id = :account_id");
                    $stmtSameEmail->bindParam(':new_email', $new_email);
                    $stmtSameEmail->bindParam(':account_id', $account_id);
                    $stmtSameEmail->execute();

                    // Prepare query to check if email already exists
                    $stmtEmailExist = $db->prepare("SELECT email FROM tblUserAccounts WHERE email = :new_email");
                    $stmtEmailExist->bindParam(':new_email', $new_email);
                    $stmtEmailExist->execute();

                    // Verify if email already exists
                    if ($stmtSameEmail->rowCount() > 0) {
                        return "Current and new email should not be the same";
                    } 
                    else if ($stmtEmailExist->rowCount() > 0) {
                        return "Email already exists";
                    } 
                    else {
                        // Prepare query to update email
                        $stmtUpdate = $db->prepare("UPDATE tblUserAccounts SET email = :new_email WHERE account_id = :account_id");
                        $stmtUpdate->bindParam(':new_email', $new_email);
                        $stmtUpdate->bindParam(':account_id', $account_id);

                        // Execute the query
                        $result = $stmtUpdate->execute();
                        
                        // Returns 1 if true, 0 if false
                        return $result;
                    }
                }
                else {
                    return "Password is incorrect";
                }
            }
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

    public static function updateAccountPassword($account_id, $current_password, $new_password) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Encrypt new password
            $new_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Prepare query to check if account with the given account id exists
            $stmtAccountExist = $db->prepare("SELECT account_id, username, password FROM tblUserAccounts WHERE account_id = :account_id");
            $stmtAccountExist->bindParam(':account_id', $account_id);
            $stmtAccountExist->execute();

            // Fetches the row from the result set
            $account = $stmtAccountExist->fetch(PDO::FETCH_ASSOC);

            // Verify account
            if ($account) {
                // Verify the password of the account
                if (password_verify($current_password, $account["password"])) {
                    // Prepare query to update password
                    $stmtUpdate = $db->prepare("UPDATE tblUserAccounts SET password = :new_password WHERE account_id = :account_id");
                    $stmtUpdate->bindParam(':new_password', $new_password);
                    $stmtUpdate->bindParam(':account_id', $account_id);

                    // Execute the query
                    $result = $stmtUpdate->execute();

                    // Returns 1 if true, 0 if false
                    return $result;
                }
                else {
                    return "Password is incorrect";
                }
            }
            
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

    public static function countAccounts() {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare query to get the number of user accounts
            $stmtCountAccounts = $db->prepare("SELECT COUNT(*) as number_of_user_accounts FROM tblUserAccounts");
            $stmtCountAccounts->execute();

            $result = array();
            while ($row = $stmtCountAccounts->fetch(PDO::FETCH_ASSOC)) {
                $result['Number of Users'] = $row['number_of_user_accounts'];
            }

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

    public static function getAccounts() {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare query to get all the user accounts
            $stmtGetAccounts = $db->prepare("SELECT * FROM tblUserAccounts");
            $stmtGetAccounts->execute();

            $result = $stmtGetAccounts->fetchAll(PDO::FETCH_ASSOC);

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

    public static function updateAccount($account_id, $new_username, $new_password, $new_email) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare query to check if account with the given account id exists
            $stmtAccountExist = $db->prepare("SELECT account_id, username, password FROM tblUserAccounts WHERE account_id = :account_id");
            $stmtAccountExist->bindParam(':account_id', $account_id);
            $stmtAccountExist->execute();

            // Fetches the row from the result set
            $account = $stmtAccountExist->fetch(PDO::FETCH_ASSOC);

            // Verify account
            if ($account) {
                // Prepare query to check if username already exists except for the account to be edited
                $stmtUsernameExist = $db->prepare("SELECT username FROM tblUserAccounts WHERE username = :new_username AND account_id != :account_id");
                $stmtUsernameExist->bindParam(':new_username', $new_username);
                $stmtUsernameExist->bindParam(':account_id', $account_id);
                $stmtUsernameExist->execute();

                // Prepare query to check if email already exists except for the account to be edited
                $stmtEmailExist = $db->prepare("SELECT email FROM tblUserAccounts WHERE email = :new_email AND account_id != :account_id");
                $stmtEmailExist->bindParam(':new_email', $new_email);
                $stmtEmailExist->bindParam(':account_id', $account_id);
                $stmtEmailExist->execute();

                // Prepare query to get password
                $stmtGetPassword = $db->prepare("SELECT password FROM tblUserAccounts WHERE account_id = :account_id");
                $stmtGetPassword->bindParam(':account_id', $account_id);
                $stmtGetPassword->execute();
                $retrievedPassword = $stmtGetPassword->fetchAll(PDO::FETCH_ASSOC);

                // Verify if username already exists
                if ($stmtUsernameExist->rowCount() > 0) {
                    return "Username already exists";
                }
                else if ($stmtEmailExist->rowCount() > 0) {
                    return "Email already exists";
                }
                else if ($retrievedPassword[0]['password'] === $new_password) {
                    // Prepare query to update username
                    $stmtUpdate = $db->prepare("UPDATE tblUserAccounts SET username = :new_username, password = :new_password, email = :new_email WHERE account_id = :account_id");
                    $stmtUpdate->bindParam(':new_username', $new_username);
                    $stmtUpdate->bindParam(':new_password', $new_password);
                    $stmtUpdate->bindParam(':new_email', $new_email);
                    $stmtUpdate->bindParam(':account_id', $account_id);

                    // Execute the query
                    $result = $stmtUpdate->execute();

                    // Returns 1 if true, 0 if false
                    return $result;
                }
                else {
                    $passwordHash = password_hash($new_password, PASSWORD_BCRYPT);

                    // Prepare query to update username
                    $stmtUpdate = $db->prepare("UPDATE tblUserAccounts SET username = :new_username, password = :new_password, email = :new_email WHERE account_id = :account_id");
                    $stmtUpdate->bindParam(':new_username', $new_username);
                    $stmtUpdate->bindParam(':new_password', $passwordHash);
                    $stmtUpdate->bindParam(':new_email', $new_email);
                    $stmtUpdate->bindParam(':account_id', $account_id);

                    // Execute the query
                    $result = $stmtUpdate->execute();

                    // Returns 1 if true, 0 if false
                    return $result;
                }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function deleteAccount($account_id) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare query to delete the user account
            $stmtDeleteAccount = $db->prepare("DELETE FROM tblUserAccounts WHERE account_id = :account_id");
            $stmtDeleteAccount->bindParam('account_id', $account_id);

            $result = $stmtDeleteAccount->execute();

            return $result;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>