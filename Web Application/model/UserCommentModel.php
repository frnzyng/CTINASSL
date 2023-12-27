<?php
class UserCommentModel {
    
    public static function submitComment($post_id, $account_id, $username, $comment_content) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare and execute a query to insert a new comment
            $stmt = $db->prepare("INSERT INTO tblComments (post_id, account_id, username, comment_content, comment_datetime) VALUES (:post_id, :account_id, :username, :comment_content, NOW())");
            $stmt->bindParam(':post_id', $post_id);
            $stmt->bindParam(':account_id', $account_id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':comment_content', $comment_content);
    
            // Execute the query
            $success = $stmt->execute();
    
            // Check if the query was successful
            if ($success) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Handle PDO exceptions
            echo "PDO Exception: " . $e->getMessage();
        } finally {
            // Close the database connection
            $db = null;
        }
    }    

    public static function getComment($post_id) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare and execute a query to insert a new post
            $stmt = $db->prepare("SELECT * FROM tblComments WHERE post_id = :post_id");
            $stmt->bindParam(':post_id', $post_id);
            // Execute the query
            $stmt->execute();

            // Fetch all results as an associative array
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return the result
            return $comments;
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