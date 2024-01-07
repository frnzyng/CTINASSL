<?php
class UserPostModel {

    public static function submitPost($account_id, $username, $post_topic, $post_content) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare query to insert a new post
            $stmtPost = $db->prepare("INSERT INTO tblPosts (account_id, username, post_topic, post_content, post_datetime) VALUES (:account_id, :username, :post_topic, :post_content, NOW())");
            $stmtPost->bindParam(':account_id', $account_id);
            $stmtPost->bindParam(':username', $username);
            $stmtPost->bindParam(':post_topic', $post_topic);
            $stmtPost->bindParam(':post_content', $post_content);
    
            // Execute the query
            $result = $stmtPost->execute();
    
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

    public static function getPost() {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare query to retrieve post
            $stmtGetPost = $db->prepare("SELECT * FROM tblPosts");

            // Execute the query
            $stmtGetPost->execute();

            // Retrieve all results as an associative array
            $retrievedPosts = $stmtGetPost->fetchAll(PDO::FETCH_ASSOC);

            // Return the retrieved posts
            return $retrievedPosts;
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

    public static function getUserAccountPost($account_id) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare query to retrieve post
            $stmtGetPost = $db->prepare("SELECT * FROM tblPosts WHERE account_id = :account_id");
            $stmtGetPost->bindParam(":account_id", $account_id);

            // Execute the query
            $stmtGetPost->execute();

            // Retrieve all results as an associative array
            $retrievedPosts = $stmtGetPost->fetchAll(PDO::FETCH_ASSOC);

            // Return the retrieved posts
            return $retrievedPosts;
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

    public static function editPost($post_id, $new_post_topic, $new_post_content) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare query to update a post
            $stmtUpdatePost = $db->prepare("UPDATE tblPosts SET post_topic = :new_post_topic, post_content = :new_post_content, post_datetime = NOW() WHERE post_id = :post_id");
            $stmtUpdatePost->bindParam(':new_post_topic', $new_post_topic);
            $stmtUpdatePost->bindParam(':new_post_content', $new_post_content);
            $stmtUpdatePost->bindParam(':post_id', $post_id);
    
            // Execute the query
            $result = $stmtUpdatePost->execute();
    
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

    public static function deletePost($post_id) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare query to insert a new post
            $stmtDeletePost = $db->prepare("DELETE FROM tblPosts WHERE post_id = :post_id");
            $stmtDeletePost->bindParam(':post_id', $post_id);
    
            // Execute the query
            $result = $stmtDeletePost->execute();
    
            if ($result) {
                return true;
            }
            else if (!$result) {
                // Check if an error occured
                $errorInfo = $stmtDeletePost->errorInfo();
                if ($errorInfo) {
                    return false;
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
}
?>