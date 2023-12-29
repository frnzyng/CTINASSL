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
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();

                // Validate and sanitize form inputs
                $account_id = $sessionController->getAccountId();
                $username = $sessionController->getUsername();
                $post_topic = trim($_POST["post_topic"]);
                $post_content = trim($_POST["post_content"]);

                if ($account_id === null && $username === null) {
                    $_SESSION["error_message"] = "Session Expired";
                    header('Location:../view/user-home.php');             
                } 
                else if ($post_topic === "" && $post_content === "") {
                    $_SESSION["error_message"] = "Fields should not be blank";
                    header('Location:../view/user-home.php');
                }
                else{
                    include_once("../model/UserPostModel.php");
                    $submittedPost = UserPostModel::submitPost($account_id, $username, $post_topic, $post_content);

                    if ($submittedPost === true) {
                        $_SESSION["success_message"] = "Posted successfully!";
                        header('Location:../view/user-home.php');
                    } 
                    else if ($submittedPost === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message"] = "Error posting";
                        header('Location:../view/user-home.php');
                    }
                    // Don't put else block here
                }
            }
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public static function handlePostRetrieval() {
        try {
            include_once("../model/UserPostModel.php");
            $retrievedPosts = UserPostModel::getPost();

            return $retrievedPosts;
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

                if ($account_id === null && $username === null) {
                    $_SESSION["error_message"] = "Session Expired";
                    header('Location:../view/user-home.php');             
                } 
                else if ($comment_content === "") {
                    $_SESSION["error_message"] = "Fields should not be blank";
                    header('Location:../view/user-home.php');
                }
                else{
                    include_once("../model/UserCommentModel.php");
                    $success = UserCommentModel::submitComment($post_id, $account_id, $username, $comment_content);
    
                    if ($submittedPost === true) {
                        $_SESSION["success_message"] = "Comment posted successfully!";
                        header('Location:../view/user-home.php');
                    } 
                    else if ($submittedPost === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message"] = "Error posting comment";
                        header('Location:../view/user-home.php');
                    }
                    // Don't put else block here
                }
            }         
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function handleCommentRetrieval($post_id) {
        try {
            include_once("../model/UserCommentModel.php");
            $retrievedComments = UserCommentModel::getComment($post_id);

            return $retrievedComments;
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
        } 
        elseif ($diff->m > 0) {
            $diffString .= $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ';
        } 
        elseif ($diff->d > 0) {
            $diffString .= $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ';
        } 
        elseif ($diff->h > 0) {
            $diffString .= $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ';
        } 
        elseif ($diff->i > 0) {
            $diffString .= $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ';
        } 
        else {
            $diffString = 'Just now';
        }
    
        return $diffString . 'ago';
    }
}
?>
