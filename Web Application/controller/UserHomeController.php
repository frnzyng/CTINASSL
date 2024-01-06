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
else if ($action === 'handleDeletePost') {
    $controller->handleDeletePost();
}
else if ($action === 'handleDeleteComment') {
    $controller->handleDeleteComment();
}
else if ($action === 'handleEditPost') {
    $controller->handleEditPost();
}
else if ($action === 'handleEditComment') {
    $controller->handleEditComment();
}

class UserHomeController {
    
    public function handlePostSubmission() {
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();
                $account_id = $sessionController->getAccountId();
                $username = $sessionController->getUsername();
                
                // Validate and sanitize form inputs  
                $post_topic = trim($_POST["post_topic"]);
                $post_content = trim($_POST["post_content"]);

                if ($account_id === null && $username === null) {
                    $_SESSION["error_message_submit_post"] = "Session Expired";
                    header('Location:../view/user-home.php');             
                } 
                else if ($post_topic === "" && $post_content === "") {
                    $_SESSION["error_message_submit_post"] = "Fields should not be blank";
                    header('Location:../view/user-home.php');
                }
                else{
                    include_once("../model/UserPostModel.php");
                    $submittedPost = UserPostModel::submitPost($account_id, $username, $post_topic, $post_content);

                    if ($submittedPost === true) {
                        $_SESSION["success_message_submit_post"] = "Posted successfully!";
                        header('Location:../view/user-home.php');
                    } 
                    else if ($submittedPost === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_submit_post"] = "Error posting";
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

    public function handleEditPost() {
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();
                $account_id = $sessionController->getAccountId();
                $username = $sessionController->getUsername();
                
                // Validate and sanitize form inputs  
                $post_id = trim($_POST["post_id"]);
                $new_post_topic = trim($_POST["new_post_topic"]);
                $new_post_content = trim($_POST["new_post_content"]);

                if ($account_id === null && $username === null) {
                    $_SESSION["error_message_edit_post"] = "Session Expired";
                    header('Location:../view/user-home.php');             
                } 
                else if ($post_id === "" && $post_id === null) {
                    $_SESSION["error_message_edit_post"] = "Post not found";
                    header('Location:../view/user-home.php');
                }
                else if ($new_post_topic === "" && $new_post_content === "") {
                    $_SESSION["error_message_edit_post"] = "Fields should not be blank";
                    header('Location:../view/user-home.php');
                }
                else{
                    include_once("../model/UserPostModel.php");
                    $editedPost = UserPostModel::editPost($post_id, $new_post_topic, $new_post_content);

                    if ($editedPost === true) {
                        $_SESSION["success_message_edit_post"] = "Posted is updated successfully!";
                        header('Location:../view/user-home.php');
                    } 
                    else if ($editedPost === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_edit_post"] = "Error updating post";
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

    public static function handleDeletePost() {
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Validate and sanitize form 
                $sessionController = new SessionController();
                $account_id = $sessionController->getAccountId();
                $username = $sessionController->getUsername();
                $post_id = trim($_POST["post_id"]);

                if ($account_id === null && $username === null) {
                    $_SESSION["error_message_delete_post"] = "Session Expired";
                    header('Location:../view/user-home.php');             
                }
                else {
                    include_once("../model/UserPostModel.php");
                    $deletedPost = UserPostModel::deletePost($post_id);
        
                    if ($deletedPost === true) {
                        $_SESSION["success_message_delete_post"] = "Post is deleted successfully!";
                        header('Location:../view/user-home.php');           
                    } 
                    else if ($deletedPost === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_delete_post"] = "Error in deleting post";
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


    public function handleCommentSubmission() {
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();
                $account_id = $sessionController->getAccountId();
                $username = $sessionController->getUsername();

                // Validate and sanitize form inputs
                $post_id = $_POST["post_id"];
                $comment_content = trim($_POST["comment_content"]);

                if ($account_id === null && $username === null) {
                    $_SESSION["error_message_submit_comment"] = "Session Expired";
                    header('Location:../view/user-home.php');             
                } 
                else if ($comment_content === "") {
                    $_SESSION["error_message_submit_comment"] = "Fields should not be blank";
                    header('Location:../view/user-home.php');
                }
                else{
                    include_once("../model/UserCommentModel.php");
                    $submittedComment = UserCommentModel::submitComment($post_id, $account_id, $username, $comment_content);
    
                    if ($submittedComment === true) {
                        $_SESSION["success_message_submit_comment"] = "Comment posted successfully!";
                        header('Location:../view/user-home.php');
                    } 
                    else if ($submittedComment === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_submit_comment"] = "Error posting comment";
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

    public function handleEditComment() {
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new SessionController();
                $account_id = $sessionController->getAccountId();
                $username = $sessionController->getUsername();
                
                // Validate and sanitize form inputs  
                $comment_id = trim($_POST["comment_id"]);
                $new_comment_content = trim($_POST["new_comment_content"]);

                if ($account_id === null && $username === null) {
                    $_SESSION["error_message_edit_comment"] = "Session Expired";
                    header('Location:../view/user-home.php');             
                } 
                else if ($comment_id === "" && $comment_id === null) {
                    $_SESSION["error_message_edit_comment"] = "Comment not found";
                    header('Location:../view/user-home.php');
                }
                else if ($new_comment_content === "" && $new_comment_content === null) {
                    $_SESSION["error_message_edit_comment"] = "Fields should not be blank";
                    header('Location:../view/user-home.php');
                }
                else{
                    include_once("../model/UserCommentModel.php");
                    $editedComment = UserCommentModel::editComment($comment_id, $new_comment_content);

                    if ($editedComment === true) {
                        $_SESSION["success_message_edit_comment"] = "Comment is updated successfully!";
                        header('Location:../view/user-home.php');
                    } 
                    else if ($editedComment === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_edit_comment"] = "Error updating comment";
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

    public static function handleDeleteComment() {
        try {
            include_once("../controller/SessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Validate and sanitize form 
                $sessionController = new SessionController();
                $account_id = $sessionController->getAccountId();
                $username = $sessionController->getUsername();
                $comment_id = $_POST["comment_id"];
                $comment_username = $_POST["comment_username"];

                if ($account_id === null && $username === null) {
                    $_SESSION["error_message_delete_comment"] = "Session Expired";
                    header('Location:../view/user-home.php');             
                }
                else if ($username !== $comment_username) {
                    $_SESSION["error_message_delete_comment"] = "Error in deleting comment";
                    header('Location:../view/user-home.php');             
                }
                else {
                    include_once("../model/UserCommentModel.php");
                    $deletedComment = UserCommentModel::deleteComment($comment_id);
        
                    if ($deletedComment === true) {
                        $_SESSION["success_message_delete_comment"] = "Comment is deleted successfully!";
                        header('Location:../view/user-home.php');           
                    } 
                    else if ($deletedComment === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_delete_comment"] = "Error in deleting comment";
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

    public function timeAgo($datetime) {
        // Set the timezone to your local timezone (UTC+08:00)
        $timezone = new DateTimeZone('Asia/Shanghai');
    
        $now = new DateTime('now', $timezone);
        $ago = new DateTime($datetime, $timezone);
    
        $diff = $now->diff($ago);
    
        $diffString = '';
    
        if ($diff->y > 0) {
            $diffString .= $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        } elseif ($diff->m > 0) {
            $diffString .= $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        } elseif ($diff->d > 0) {
            $diffString .= $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        } elseif ($diff->h > 0) {
            $diffString .= $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        } elseif ($diff->i > 0) {
            $diffString .= $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        } else {
            $diffString = 'Just now';
        }
    
        return $diffString;
    }    
}
?>
