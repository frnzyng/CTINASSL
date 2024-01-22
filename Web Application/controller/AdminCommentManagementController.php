<?php

$action = isset($_GET['action']) ? $_GET['action'] : '';
$controller = new AdminCommentManagementController();

if ($action === 'getCountComments') {
    $controller->getCountComments();
}
else if ($action === 'handleEditComment') {
    $controller->handleEditComment();
}
else if ($action === 'handleDeleteComment') {
    $controller->handleDeleteComment();
}
class AdminCommentManagementController {

    public static function getCountComments() {
        try {
            include_once("../model/UserCommentModel.php");
            
            $count = UserCommentModel::countComments();

            return $count;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public static function handleCommentRetrieval() {
        try {
            include_once("../model/UserCommentModel.php");
            $retrievedComments = UserCommentModel::getAllComment();

            return $retrievedComments;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }

    public function handleEditComment() {
        try {
            include_once("../controller/AdminSessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new AdminSessionController();
                $admin_account_id = $sessionController->getAdminAccountId();
                $admin_username = $sessionController->getAdminUsername();
                
                // Validate and sanitize form inputs  
                $comment_id = trim($_POST["comment_id"]);
                $new_comment_content = trim($_POST["new_comment_content"]);
                $action = "Edited user's comment";
                $ip_address = $_SERVER['REMOTE_ADDR'];

                if ($admin_account_id === null && $admin_username === null) {
                    $_SESSION["error_message_edit_comment"] = "Session Expired";
                    header('Location:../view/admin-comment-management.php');             
                } 
                else if ($comment_id === "" && $comment_id === null) {
                    $_SESSION["error_message_edit_comment"] = "Comment not found";
                    header('Location:../view/admin-comment-management.php');
                }
                else if ($new_comment_content === "" && $new_comment_content === null) {
                    $_SESSION["error_message_edit_comment"] = "Fields should not be blank";
                    header('Location:../view/admin-comment-management.php');
                }
                else{
                    include_once("../model/UserCommentModel.php");
                    $editedComment = UserCommentModel::editComment($comment_id, $new_comment_content);

                    if ($editedComment === true) {
                        include_once("../model/AdminAccountModel.php");
                        $recordedLog = AdminAccountModel::recordActivityLog($admin_account_id, $action, $ip_address);

                        if ($recordedLog) {
                            $_SESSION["success_message_edit_comment"] = "Comment is updated successfully!";
                            header('Location:../view/admin-comment-management.php');
                        }
                    } 
                    else if ($editedComment === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_edit_comment"] = "Error updating comment";
                        header('Location:../view/admin-comment-management.php');
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
            include_once("../controller/AdminSessionController.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get session
                $sessionController = new AdminSessionController();
                $admin_account_id = $sessionController->getAdminAccountId();
                $admin_username = $sessionController->getAdminUsername();

                // Validate and sanitize form inputs
                $comment_id = $_POST["comment_id"];
                $comment_username = $_POST["comment_username"];
                $action = "Deleted user's comment";
                $ip_address = $_SERVER['REMOTE_ADDR'];

                if ($admin_account_id === null && $admin_username === null) {
                    $_SESSION["error_message_delete_comment"] = "Session Expired";
                    header('Location:../view/admin-comment-management.php');             
                }
                else if ($comment_id === "" && $comment_id === null) {
                    $_SESSION["error_message_delete_comment"] = "Comment not found";
                    header('Location:../view/admin-comment-management.php');             
                }
                else {
                    include_once("../model/UserCommentModel.php");
                    $deletedComment = UserCommentModel::deleteComment($comment_id);
        
                    if ($deletedComment === true) {
                        include_once("../model/AdminAccountModel.php");
                        $recordedLog = AdminAccountModel::recordActivityLog($admin_account_id, $action, $ip_address);

                        if ($recordedLog) {
                            $_SESSION["success_message_delete_comment"] = "Comment is deleted successfully!";
                            header('Location:../view/admin-comment-management.php'); 
                        }          
                    } 
                    else if ($deletedComment === false) {
                        // If an exception occurred in the model, store the error in the session
                        $_SESSION["error_message_delete_comment"] = "Error in deleting comment";
                        header('Location:../view/admin-comment-management.php');
                    }
                    // Don't put else block here
                }
            }
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }
}
?>