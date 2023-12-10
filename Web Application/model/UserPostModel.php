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
    
            // Prepare and execute a query to insert a new post
            $stmt = $db->prepare("INSERT INTO tblPosts (account_id, username, post_topic, post_content, post_datetime) VALUES (:account_id, :username, :post_topic, :post_content, NOW())");
            $stmt->bindParam(':account_id', $account_id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':post_topic', $post_topic);
            $stmt->bindParam(':post_content', $post_content);
    
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

    public static function getPost() {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare and execute a query to insert a new post
            $stmt = $db->prepare("SELECT * FROM tblPosts");
            // Execute the query
            $stmt->execute();

            // Fetch all results as an associative array
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return the result
            return $posts;
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