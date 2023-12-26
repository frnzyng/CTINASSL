<?php

// Check for the action parameter in the URL
$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new UserHomeController();

if ($action === 'handlePostSubmission') {
    $controller->handlePostSubmission();
}
else if ($action === 'handleCommentSubmission') {
    $controller->handleCommentSubmission();
}

class UserHomeController {
    
    public function handlePostSubmission() {
        include_once("../controller/SessionController.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get session
            $sessionController = new SessionController();

            // Validate and sanitize form inputs
            $account_id = $sessionController->getAccountId();
            $username = $sessionController->getUsername();
            $post_topic = trim($_POST["post_topic"]);
            $post_content = trim($_POST["post_content"]);

            // You may want to perform additional validation here

            // Example: Insert data into the tblPosts table using the model
            if ($account_id != "" && $username != "" && $post_topic != "" && $post_content != "") {
                include_once("../model/UserPostModel.php");
                $success = UserPostModel::submitPost($account_id, $username, $post_topic, $post_content);
            }
            else{
                $_SESSION["error_message"] = "Fields should not be null";
            }

            // Load the appropriate view based on success or failure
            if ($success) {
                header('Location:../view/user-home.php');
                $_SESSION["error_message"] = "Post submitted successfully!";
                return $success;
            } else {
                header('Location:../view/user-home.php');
                $_SESSION["error_message"] = "Error submitting post";
            }
        }
    }

    public static function handlePostRetrieval() {
        try {
            include_once("../model/UserPostModel.php");
            $posts = UserPostModel::getPost();

            return $posts;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public function handleCommentSubmission() {
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();

                // Validate and sanitize form inputs
                $post_id = $_POST["post_id"];
                $account_id = $sessionController->getAccountId();
                $username = $sessionController->getUsername();
                $comment_content = trim($_POST["comment_content"]);

                // You may want to perform additional validation here

                // Example: Insert data into the tblPosts table using the model
                if ($post_id != "" && $account_id != "" && $username != "" && $comment_content != "") {
                    include_once("../model/UserCommentModel.php");
                    $success = UserCommentModel::submitComment($post_id, $account_id, $username, $comment_content);
                }
                else{
                    $_SESSION["error_message"] = "Fields should not be null";
                }

                // Load the appropriate view based on success or failure
                if ($success) {
                    header('Location:../view/user-home.php');
                    $_SESSION["error_message"] = "Comment submitted successfully!";
                    return $success;
                } else {
                    header('Location:../view/user-home.php');
                    $_SESSION["error_message"] = "Error submitting comment";
                }
                header('Location:../view/user-home.php');
            }         
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function handleCommentRetrieval($post_id) {
        try {
            include_once("../model/UserCommentModel.php");
            $comments = UserCommentModel::getComment($post_id);

            return $comments;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public function timeAgo($datetime) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diffString = '';
    
        if ($diff->y > 0) {
            $diffString .= $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ';
        } elseif ($diff->m > 0) {
            $diffString .= $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ';
        } elseif ($diff->d > 0) {
            $diffString .= $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ';
        } elseif ($diff->h > 0) {
            $diffString .= $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ';
        } elseif ($diff->i > 0) {
            $diffString .= $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ';
        } else {
            $diffString = 'Just now';
        }
    
        return $diffString . 'ago';
    }
}
?>
