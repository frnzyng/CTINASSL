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
    
            // Prepare query to insert a new comment
            $stmtComment = $db->prepare("INSERT INTO tblComments (post_id, account_id, username, comment_content, comment_datetime) VALUES (:post_id, :account_id, :username, :comment_content, NOW())");
            $stmtComment->bindParam(':post_id', $post_id);
            $stmtComment->bindParam(':account_id', $account_id);
            $stmtComment->bindParam(':username', $username);
            $stmtComment->bindParam(':comment_content', $comment_content);
    
            // Execute the query
            $result = $stmtComment->execute();
    
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

    // Gets all the comments on a specific post; change to getPostComments
    public static function getComment($post_id) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare query to retrieve comments
            $stmtGetComments = $db->prepare("SELECT * FROM tblComments WHERE post_id = :post_id");
            $stmtGetComments->bindParam(':post_id', $post_id);

            // Execute the query
            $stmtGetComments->execute();

            // Retrieve all results as an associative array
            $retrievedComments = $stmtGetComments->fetchAll(PDO::FETCH_ASSOC);

            // Return the retrieved comments
            return $retrievedComments;
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

    // Gets all comments
    public static function getAllComment() {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare query to retrieve comments
            $stmtGetComments = $db->prepare("SELECT * FROM tblComments");

            // Execute the query
            $stmtGetComments->execute();

            // Retrieve all results as an associative array
            $retrievedComments = $stmtGetComments->fetchAll(PDO::FETCH_ASSOC);

            // Return the retrieved comments
            return $retrievedComments;
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

    public static function editComment($comment_id, $new_comment_content) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare query to update a comment
            $stmtUpdateComment = $db->prepare("UPDATE tblComments SET comment_content = :new_comment_content, comment_datetime = NOW() WHERE comment_id = :comment_id");
            $stmtUpdateComment->bindParam(':new_comment_content', $new_comment_content);
            $stmtUpdateComment->bindParam(':comment_id', $comment_id);
    
            // Execute the query
            $result = $stmtUpdateComment->execute();
    
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

    public static function deleteComment($comment_id) {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Prepare query to insert a new post
            $stmtDeleteComment = $db->prepare("DELETE FROM tblComments WHERE comment_id = :comment_id");
            $stmtDeleteComment->bindParam(':comment_id', $comment_id);
    
            // Execute the query
            $result = $stmtDeleteComment->execute();
    
            if ($result) {
                return true;
            }
            else if (!$result) {
                // Check if an error occured
                $errorInfo = $stmtDeleteComment->errorInfo();
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

    public static function countComments() {
        try {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "BlogSite";
    
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare query to get the number of user accounts
            $stmtCountPosts = $db->prepare("SELECT COUNT(*) as number_of_comments FROM tblComments");
            $stmtCountPosts->execute();

            $result = array();
            while ($row = $stmtCountPosts->fetch(PDO::FETCH_ASSOC)) {
                $result['Number of Comments'] = $row['number_of_comments'];
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
}
?>